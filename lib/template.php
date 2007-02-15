<?php
class Style {
	var $attributes = array();
	var $header = 'skins/header.php';
	var $footer = 'skins/footer.php';
	function Style($name) {
		$this->name = $name;
		include 'styles/'.$name.'/style.php';
		$this->skin = $skin;
		$this->set('style_dir', METABBS_BASE_PATH . 'styles/' . $name);
		$this->set('skin_dir', METABBS_BASE_PATH . 'skins/' . $skin);
		$this->set('title', 'MetaBBS');
	}
	function set($name, $value) {
		$this->attributes[$name] = $value;
	}
	function render($template) {
		extract($this->attributes);
		include $this->header;
		include 'skins/'.$this->skin.'/'.$template.'.php';
		include $this->footer;
	}
}

function meta_format_date($format, $now) {
	return strftime($format, $now);
}
function meta_format_date_RFC822($now) {
	return date('r', $now);
}
function autolink($string) {
	return preg_replace_callback("#([a-z]+)://(?:[-0-9a-z_.@:~\\#%=+?/]|&amp;)+#i", 'link_url', $string);
}
function link_url($match) {
	$url = $match[0];
	if (is_image($url)) {
		return image_tag($url);
	} else {
		return link_text($url);
	}
}
function is_image($path) {
	$ext = strtolower(strrchr($path, '.'));
	return ($ext == '.png' || $ext == '.gif' || $ext == '.jpg');
}
function format($str) { // deprecated. use format_plain instead
	return $str;
}
function format_plain($text) {
	return '<p>'.autolink(nl2br(htmlspecialchars($text))).'</p>';
}
function print_nav($nav = null, $separator = ' | ') {
	echo implode($separator, $nav === null ? $GLOBALS['nav'] : $nav);
}
function human_readable_size($size) {
	$units = array(' bytes', 'KB', 'MB', 'GB', 'TB');
	for ($i = 0; $size > 1024; $size /= 1024, $i++);
	return round($size, 1) . $units[$i];
}
function print_notice($text, $description) {
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	echo '<html>';
	echo '<body>';
	echo '<h2>' . $text . '</h2>';
	echo '<p>' . $description . '</p>';
	echo '</body>';
	echo '</html>';
	exit;
}
?>
