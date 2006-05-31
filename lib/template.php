<?php
function date_format($format, $date) {
	if (preg_match('/^\d{14}$/', $date)) {
		$time = mktime(substr($date, 8, 2), substr($date, 10, 2),
			substr($date, 12, 2), substr($date, 4, 2),
			substr($date, 6, 2),substr($date, 0, 4));
	}
	else if (is_numeric($date)) {
		$time = (int) $date;
	}
	else {
		$time = strtotime($date);
		if ($time < 0 || $time === FALSE) {
			$time = time();
		}
	}
	return strftime($format, $time);
}
function autolink($string) {
	return preg_replace_callback("#([a-z]+)://(?:[-0-9a-z_.@:~\\#%=+?/]|&amp;)+#i", 'link_url', $string);
}
function link_url($match) {
	$url = $match[0];
	if (is_image($url)) {
		return "<img src='$url' alt='' />";
	} else {
		return "<a href='$url'>$url</a>";
	}
}
function is_image($path) {
	$ext = strtolower(strrchr($path, '.'));
	return ($ext == '.png' || $ext == '.gif' || $ext == '.jpg');
}
function format($str) {
	return preg_replace(array("/ {2}/", "/\n /", "/\r?\n/", "/<br \/><br \/>/"), array("&nbsp;&nbsp;", "\n&nbsp;", "<br />", "</p><p>"), autolink(htmlspecialchars($str)));
}
?>
