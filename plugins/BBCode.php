<?php
// 일부 코드는 PunBB 코드에서 가져와 약간 수정되었습니다. (include/parser.php)

// 코드 저작권:
/// Copyright (C) 2002-2005  Rickard Andersson (rickard@punbb.org)
/// Licensed under GPLv2

//
// Make sure all BBCodes are lower case and do a little cleanup
//
function preparse_bbcode($text, &$errors)
{
	// Change all simple BBCodes to lower case
	$a = array('[B]', '[I]', '[U]', '[/B]', '[/I]', '[/U]');
	$b = array('[b]', '[i]', '[u]', '[/b]', '[/i]', '[/u]');
	$text = str_replace($a, $b, $text);

	// Do the more complex BBCodes (also strip excessive whitespace and useless quotes)
	$a = array( '#\[url=("|\'|)(.*?)\\1\]\s*#i',
				'#\[url\]\s*#i',
				'#\s*\[/url\]#i',
				'#\[email=("|\'|)(.*?)\\1\]\s*#i',
				'#\[email\]\s*#i',
				'#\s*\[/email\]#i',
				'#\[img\]\s*(.*?)\s*\[/img\]#is',
				'#\[colou?r=("|\'|)(.*?)\\1\](.*?)\[/colou?r\]#is');

	$b = array(	'[url=$2]',
				'[url]',
				'[/url]',
				'[email=$2]',
				'[email]',
				'[/email]',
				'[img]$1[/img]',
				'[color=$2]$3[/color]');

	// For non-signatures, we have to do the quote and code tags as well
	$a[] = '#\[quote=(&quot;|"|\'|)(.*?)\\1\]\s*#i';
	$a[] = '#\[quote\]\s*#i';
	$a[] = '#\s*\[/quote\]\s*#i';
	$a[] = '#\[code\][\r\n]*(.*?)\s*\[/code\]\s*#is';

	$b[] = '[quote=$1$2$1]';
	$b[] = '[quote]';
	$b[] = '[/quote]'."\n";
	$b[] = '[code]$1[/code]'."\n";

	// Run this baby!
	$text = preg_replace($a, $b, $text);

	$overflow = check_tag_order($text, $error);

	if ($error)
		// A BBCode error was spotted in check_tag_order()
		$errors[] = $error;
	else if ($overflow)
		// The quote depth level was too high, so we strip out the inner most quote(s)
		$text = substr($text, 0, $overflow[0]).substr($text, $overflow[1], (strlen($text) - $overflow[0]));

	return trim($text);
}


//
// Parse text and make sure that [code] and [quote] syntax is correct
//
function check_tag_order($text, &$error)
{
	// The maximum allowed quote depth
	$max_depth = 3;

	$cur_index = 0;
	$q_depth = 0;

	while (true)
	{
		// Look for regular code and quote tags
		$c_start = strpos($text, '[code]');
		$c_end = strpos($text, '[/code]');
		$q_start = strpos($text, '[quote]');
		$q_end = strpos($text, '[/quote]');

		// Look for [quote=username] style quote tags
		if (preg_match('#\[quote=(&quot;|"|\'|)(.*)\\1\]#sU', $text, $matches))
			$q2_start = strpos($text, $matches[0]);
		else
			$q2_start = 65536;

		// Deal with strpos() returning false when the string is not found
		// (65536 is one byte longer than the maximum post length)
		if ($c_start === false) $c_start = 65536;
		if ($c_end === false) $c_end = 65536;
		if ($q_start === false) $q_start = 65536;
		if ($q_end === false) $q_end = 65536;

		// If none of the strings were found
		if (min($c_start, $c_end, $q_start, $q_end, $q2_start) == 65536)
			break;

		// We are interested in the first quote (regardless of the type of quote)
		$q3_start = ($q_start < $q2_start) ? $q_start : $q2_start;

		// We found a [quote] or a [quote=username]
		if ($q3_start < min($q_end, $c_start, $c_end))
		{
			$step = ($q_start < $q2_start) ? 7 : strlen($matches[0]);

			$cur_index += $q3_start + $step;

			// Did we reach $max_depth?
			if ($q_depth == $max_depth)
				$overflow_begin = $cur_index - $step;

			++$q_depth;
			$text = substr($text, $q3_start + $step);
		}

		// We found a [/quote]
		else if ($q_end < min($q_start, $c_start, $c_end))
		{
			if ($q_depth == 0)
			{
				$error = 1;
				return;
			}

			$q_depth--;
			$cur_index += $q_end+8;

			// Did we reach $max_depth?
			if ($q_depth == $max_depth)
				$overflow_end = $cur_index;

			$text = substr($text, $q_end+8);
		}

		// We found a [code]
		else if ($c_start < min($c_end, $q_start, $q_end))
		{
			// Make sure there's a [/code] and that any new [code] doesn't occur before the end tag
			$tmp = strpos($text, '[/code]');
			$tmp2 = strpos(substr($text, $c_start+6), '[code]');
			if ($tmp2 !== false)
				$tmp2 += $c_start+6;

			if ($tmp === false || ($tmp2 !== false && $tmp2 < $tmp))
			{
				$error = 2;
				return;
			}
			else
				$text = substr($text, $tmp+7);

			$cur_index += $tmp+7;
		}

		// We found a [/code] (this shouldn't happen since we handle both start and end tag in the if clause above)
		else if ($c_end < min($c_start, $q_start, $q_end))
		{
			$error = 3;
			return;
		}
	}

	// If $q_depth <> 0 something is wrong with the quote syntax
	if ($q_depth)
	{
		$error = 4;
		return;
	}
	else if ($q_depth < 0)
	{
		$error = 5;
		return;
	}

	// If the quote depth level was higher than $max_depth we return the index for the
	// beginning and end of the part we should strip out
	if (isset($overflow_begin))
		return array($overflow_begin, $overflow_end);
	else
		return null;
}


//
// Split text into chunks ($inside contains all text inside $start and $end, and $outside contains all text outside)
//
function split_text($text, $start, $end)
{
	$tokens = explode($start, $text);

	$outside[] = $tokens[0];

	$num_tokens = count($tokens);
	for ($i = 1; $i < $num_tokens; ++$i)
	{
		$temp = explode($end, $tokens[$i]);
		$inside[] = $temp[0];
		$outside[] = $temp[1];
	}

	return array($inside, $outside);
}


//
// Truncate URL if longer than 55 characters (add http:// or ftp:// if missing)
//
function handle_url_tag($url, $link = '')
{
	$full_url = str_replace(array(' ', '\'', '`', '"'), array('%20', '', '', ''), $url);
	if (strpos($url, 'www.') === 0)			// If it starts with www, we add http://
		$full_url = 'http://'.$full_url;
	else if (strpos($url, 'ftp.') === 0)	// Else if it starts with ftp, we add ftp://
		$full_url = 'ftp://'.$full_url;
	else if (!preg_match('#^([a-z0-9]{3,6})://#', $url, $bah)) 	// Else if it doesn't start with abcdef://, we add http://
		$full_url = 'http://'.$full_url;

	// Ok, not very pretty :-)
	$link = ($link == '' || $link == $url) ? ((strlen($url) > 55) ? substr($url, 0 , 39).' &hellip; '.substr($url, -10) : $url) : stripslashes($link);

	return '<a href="'.$full_url.'">'.$link.'</a>';
}


//
// Turns an URL from the [img] tag into an <img> tag or a <a href...> tag
//
function handle_img_tag($url)
{
	$img_tag = '<img class="postimg" src="'.$url.'" alt="'.htmlspecialchars($url).'" />';
	return $img_tag;
}


//
// Convert BBCodes to their HTML equivalent
//
function do_bbcode($text)
{
	if (strpos($text, 'quote') !== false)
	{
		$text = str_replace('[quote]', '</p><blockquote><div class="incqbox"><p>', $text);
		$text = preg_replace('#\[quote=(&quot;|"|\'|)(.*)\\1\]#seU', '"</p><blockquote><div class=\"incqbox\"><h4>".str_replace(array(\'[\', \'\\"\'), array(\'&#91;\', \'"\'), \'$2\')." wrote:</h4><p>"', $text);
		$text = preg_replace('#\[\/quote\]\s*#', '</p></div></blockquote><p>', $text);
	}

	$pattern = array('#\[b\](.*?)\[/b\]#s',
					 '#\[i\](.*?)\[/i\]#s',
					 '#\[u\](.*?)\[/u\]#s',
					 '#\[url\]([^\[]*?)\[/url\]#e',
					 '#\[url=([^\[]*?)\](.*?)\[/url\]#e',
					 '#\[email\]([^\[]*?)\[/email\]#',
					 '#\[email=([^\[]*?)\](.*?)\[/email\]#',
					 '#\[color=([a-zA-Z]*|\#?[0-9a-fA-F]{6})](.*?)\[/color\]#s');

	$replace = array('<strong>$1</strong>',
					 '<em>$1</em>',
					 '<span class="bbu">$1</span>',
					 'handle_url_tag(\'$1\')',
					 'handle_url_tag(\'$1\', \'$2\')',
					 '<a href="mailto:$1">$1</a>',
					 '<a href="mailto:$1">$2</a>',
					 '<span style="color: $1">$2</span>');

	// This thing takes a while! :)
	$text = preg_replace($pattern, $replace, $text);

	return $text;
}


//
// Make hyperlinks clickable
//
function do_clickable($text)
{
	$text = ' '.$text;

	$text = preg_replace('#([\s\(\)])(https?|ftp|news){1}://([\w\-]+\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^"\s\(\)<\[]*)?)#ie', '\'$1\'.handle_url_tag(\'$2://$3\')', $text);
	$text = preg_replace('#([\s\(\)])(www|ftp)\.(([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^"\s\(\)<\[]*)?)#ie', '\'$1\'.handle_url_tag(\'$2.$3\', \'$2.$3\')', $text);

	return substr($text, 1);
}


//
// Parse message text
//
function format_bbcode($text)
{
	// Convert applicable characters to HTML entities
	$text = htmlspecialchars($text);

	// If the message contains a code tag we have to split it up (text within [code][/code] shouldn't be touched)
	if (strpos($text, '[code]') !== false && strpos($text, '[/code]') !== false)
	{
		list($inside, $outside) = split_text($text, '[code]', '[/code]');
		$outside = array_map('ltrim', $outside);
		$text = implode('<">', $outside);
	}

	$text = do_clickable($text);
	$text = do_bbcode($text);
	$text = preg_replace('#\[img\]((ht|f)tps?://)([^\s<"]*?)\[/img\]#e', 'handle_img_tag(\'$1$3\')', $text);

	// Deal with newlines, tabs and multiple spaces
	$pattern = array("\n", "\t", '  ', '  ');
	$replace = array('<br />', '&nbsp; &nbsp; ', '&nbsp; ', ' &nbsp;');
	$text = str_replace($pattern, $replace, $text);

	// If we split up the message before we have to concatenate it together again (code tags)
	if (isset($inside))
	{
		$outside = explode('<">', $text);
		$text = '';

		$num_tokens = count($outside);

		for ($i = 0; $i < $num_tokens; ++$i)
		{
			$text .= $outside[$i];
			if (isset($inside[$i]))
			{
				$num_lines = ((substr_count($inside[$i], "\n")) + 3) * 1.5;
				$height_str = ($num_lines > 35) ? '35em' : $num_lines.'em';
				$text .= '</p><div class="codebox"><div class="incqbox"><h4>Code:</h4><div class="scrollbox" style="height: '.$height_str.'"><pre>'.$inside[$i].'</pre></div></div></div><p>';
			}
		}
	}

	// Add paragraph tag around post, but make sure there are no empty paragraphs
	$text = str_replace('<p></p>', '', '<p>'.$text.'</p>');

	return $text;
}

class BBCode extends Plugin {
	var $description = 'BBCode 형식을 처리합니다.';

	function on_init() {
		add_filter('PostList', array(&$this, 'format'), 500);
		add_filter('PostView', array(&$this, 'format'), 500);
		add_filter('PostViewRSS', array(&$this, 'format'), 500);
		add_filter('PostViewComment', array(&$this, 'format'), 500);
		add_filter('CommentViewFeed', array(&$this, 'format'), 500);
	}
	function format(&$post) {
		if (!$post->body) return;
		$post->body = format_bbcode($post->body);
	}
}

register_plugin('BBCode');
?>
