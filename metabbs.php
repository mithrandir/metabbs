<?php
require 'lib/common.php';

$parts = explode('/', $_SERVER['PATH_INFO'], 4);
$len = count($parts);
if ($len == 4) { // /controller/action/id
	$controller = $parts[1];
	$action = $parts[2];
	$id = $parts[3];
} else if ($len == 2 || $len == 3) { // /controller/id
	$controller = $parts[1];
	$action = 'index';
	$id = $len == 3 ? $parts[2] : null;
} else {
	print_notice('Requested URL is not valid.', 'Valid URL format is '.full_url_for("<em>controller</em>", "<em>action</em>").'<br />If you are administrator, go to '.link_to('administration page', 'admin'));
}

$layout = new Layout;
$title = 'MetaBBS';
$view = DEFAULT_VIEW;

// import plugins
import_plugin('_base');
foreach (get_enabled_plugins() as $plugin) {
	import_plugin($plugin->name);
}

@include 'app/controllers/' . $controller . '.php';
$action_dir = 'app/controllers/' . $controller;
if (!run_hook_handler($controller, $action)) {
	include($action_dir . '/' . $action . '.php');
}
if (!isset($skin)) {
	if (isset($board)) {
		if (!$board->style) $board->style = 'default';
		$style = $board->get_style();
		$skin = $style->skin;
		$style_dir = $style->get_path();
	} else {
		$skin = 'default';
		$style_dir = METABBS_BASE_PATH . 'styles/default';
	}
}
$_skin_dir = 'skins/' . $skin;
$skin_dir = METABBS_BASE_PATH . $_skin_dir;

$layout->add_javascript(METABBS_BASE_PATH . 'elements/prototype.js');
if ($view == ADMIN_VIEW) {
	$layout->add_stylesheet(METABBS_BASE_PATH . 'elements/style.css');
	$layout->add_javascript(METABBS_BASE_PATH . 'elements/admin.js');
	$layout->header = $layout->footer = '';
} else {
	$layout->add_stylesheet($style_dir . '/style.css');
	$layout->add_javascript(METABBS_BASE_PATH . 'elements/script.js');
	$layout->wrap('<div id="meta">', '</div>');
}

foreach (get_header_paths() as $header) include $header;
echo $layout->header;
include "app/views/$controller/$action.php";
echo $layout->footer;
foreach (get_footer_paths() as $footer) include $footer;
?>
