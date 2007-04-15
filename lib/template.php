<?php
class Style {
	function Style($name) {
		$this->name = $name;
		include "styles/$name/style.php";
		$this->skin = $skin;
	}
	function get_path() {
		return METABBS_BASE_PATH . 'styles/' . $this->name;
	}
}
class Layout {
	var $stylesheets = array();
	var $javascripts = array();
	var $header, $footer;

	function add_stylesheet($path) {
		$this->stylesheets[] = $path;
	}
	function add_javascript($path) {
		$this->javascripts[] = $path;
	}
	function print_head() {
		foreach ($this->stylesheets as $stylesheet) {
			echo '<link rel="stylesheet" href="'.$stylesheet.'" type="text/css" />';
		}
		foreach ($this->javascripts as $javascript) {
			echo '<script type="text/javascript" src="' . $javascript . '"></script>';
		}
	}
	function wrap($header, $footer) {
		$this->header .= $header;
		$this->footer = $footer . $this->footer;
	}
}

function get_header_paths() {
	global $view, $_skin_dir, $config;
	if ($view == 'admin')
		return array('elements/admin_header.php');
	else
		return array($config->get('global_header', 'elements/default_header.php'), $_skin_dir . '/header.php');
}
function get_footer_paths() {
	global $view, $_skin_dir, $config;
	if ($view == 'admin')
		return array('elements/admin_footer.php');
	else
		return array($_skin_dir . '/footer.php', $config->get('global_footer', 'elements/default_footer.php'));
}

function meta_format_date($format, $now) {
	return strftime($format, $now);
}
function meta_format_date_RFC822($now) {
	return date('r', $now);
}
function autolink($string) {
	return preg_replace_callback("#([a-z]+)://[-0-9a-z_.@:~\\#%=+?/$;,&]+#i", 'link_url', $string);
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
