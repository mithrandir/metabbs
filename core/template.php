<?php
function get_global_template_vars() {
	return array(
		'account' => $GLOBALS['account'],
		'action' => $GLOBALS['routes']['action'],
	);
}

function print_comment_tree($comments) {
	global $template;
	if (!is_array($comments)) {
		if (!$comments->comments) return;
		$comments = $comments->comments;
		apply_filters_array('PostViewComment', $comments);
	}
	$template->view = '_comment';
	foreach ($comments as $comment) {
		$template->set('comment', $comment);
		$template->render_partial();
	}
}

function get_template($board, $view) {
	$style = $board->get_style();
	return $style->get_template($view);
}

class Skin {
	function Skin($name) {
		$this->name = $name;
		if (file_exists("skins/$name/skin.php")) {
			include "skins/$name/skin.php";
			$this->engine = $template_engine;
			$this->options = $options;
		} else {
			$this->engine = 'default';
			$this->options = array();
		}
		require_once "core/template_engines/$this->engine.php";
		$this->template_class = $this->engine.'Template';
	}
	function get_template($view) {
		$template = new $this->template_class($this->get_path(), $view);
		$template->set('skin_dir', METABBS_BASE_PATH.$this->get_path());
		$template->set('_skin_dir', $this->get_path());
		return $template;
	}
	function get_path() {
		return "skins/$this->name";
	}
	function get_option($key, $default = null) {
		if (array_key_exists($key, $this->options)) {
			return $this->options[$key];
		} else {
			return $default;
		}
	}
}

class Style {
	function Style($name) {
		$this->name = $name;
		include "styles/$name/style.php";
		$this->skin = new Skin($skin);
		$this->fullname = isset($style_name) ? $style_name : $name;
		$this->creator = @$style_creator;
		$this->license = @$style_license;
	}
	function get_path() {
		return METABBS_BASE_PATH . 'styles/' . $this->name;
	}
	function get_template($view) {
		$template = $this->skin->get_template($view);
		$template->set('style_dir', $this->get_path());
		return $template;
	}
}

class Theme {
	function Theme($name) {
		$this->name = $name;
		$this->engine = 'default';
		$this->template_class = $this->engine.'Template';
	}
	function get_path() {
		return METABBS_BASE_PATH . 'themes/' . get_current_theme() . '/' . $this->name . '.php';
	}
	function get_template($view) {
/* DEBUG */
//		var_dump($this->template_class);
		require_once "core/template_engines/$this->engine.php";
		$template = new $this->template_class($this->get_path(), $view);
		return $template;
	}
}

define('DEFAULT_VIEW', 0);
define('ADMIN_VIEW', 1);

class Layout {
	var $stylesheets = array();
	var $javascripts = array();
	var $metadata = array();
	var $header, $footer;
	var $head = '';
	var $title = 'MetaBBS';

	function Layout() {
		$this->add_meta('Generator', 'MetaBBS '.METABBS_VERSION);
	}
	function add_stylesheet($path) {
		$this->add_link('stylesheet', 'text/css', $path);
	}
	function add_javascript($path) {
		$this->head .= "<script type=\"text/javascript\" src=\"$path\"></script>\n";
	}
	function add_meta($name, $content) {
		$this->head .= "<meta name=\"$name\" content=\"".htmlspecialchars($content)."\" />\n";
	}
	function add_link($rel, $type, $href, $title = '') {
		$this->head .= '<link rel="' . $rel . '" href="' . $href . '" type="' . $type . '"';
		if ($title) $this->head .= ' title="' . $title . '"';
		$this->head .= " />\n";
	}
	function print_head() {
		echo $this->head;
	}
	function wrap($header, $footer) {
		$this->header .= $header;
		$this->footer = $footer . $this->footer;
	}
}

function get_header_path() {
	global $view, $config;
	$header_path = $view == ADMIN_VIEW ? 'media/admin_header.php' : $config->get('global_header', 'media/default_header.php');
	apply_filters('GetHeaderPath', $header_path);
	return $header_path;
}
function get_footer_path() {
	global $view, $config;
	$footer_path = $view == ADMIN_VIEW ? 'media/admin_footer.php' : $config->get('global_footer', 'media/default_footer.php');
	apply_filters('GetFooterPath', $footer_path);
	return $footer_path;
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
		return link_text($url, shorten_path($url));
	}
}
function shorten_path($path) {
	if (strlen($path) > 55) {
		return substr($path, 0, 39).' &hellip; '.substr($path, -10);
	} else {
		return $path;
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
	$theme = get_current_theme();
	include 'themes/'.$theme.'/error.php';
	exit;
}
?>
