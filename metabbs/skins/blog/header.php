<?php
function url_for_blog($blog) {
	if ($blog->name == 'blog')
		return url_for('blog');
	else
		return url_for($blog);
}
function plural_link($post, $noun, $count) {
	$url = url_for($post) . '#' . $noun . 's';
	if ($count == 0)
		$text = 'no ' . $noun . 's';
	else if ($count == 1)
		$text = '1 ' . $noun;
	else
		$text = $count . ' ' . $noun . 's';
	return link_text($url, $text);
}
?>
<div id="container">
	<div id="header">
		<h1><span><a href="<?=url_for_blog($board)?>"><?=$board->title?></a></span></h1>
	</div>

	<div id="page">
		<div id="content">
