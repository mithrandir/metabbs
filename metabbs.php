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

import_enabled_plugins();

@include 'app/controllers/' . $controller . '.php';
$action_dir = 'app/controllers/' . $controller;
if (!run_hook_handler($controller, $action)) {
	include($action_dir . '/' . $action . '.php');
}
if (isset($board)) {
	$style = $board->get_style();
	$style_dir = $style->get_path();
	$_skin_dir = $style->skin->get_path();
	$skin_dir = METABBS_BASE_PATH.$_skin_dir;
} else {
	$_skin_dir = 'skins/default';
	$style_dir = METABBS_BASE_PATH.'styles/default';
}

$layout->add_javascript(METABBS_BASE_PATH . 'elements/prototype.js');
if ($view == ADMIN_VIEW) {
	$layout->add_stylesheet(METABBS_BASE_PATH . 'elements/style.css');
	$layout->add_javascript(METABBS_BASE_PATH . 'elements/admin.js');
	$layout->header = $layout->footer = '';
} else {
	$layout->add_stylesheet($style_dir . '/style.css');
	$layout->add_javascript(METABBS_BASE_PATH . 'elements/script.js');
	$layout->wrap("<div id=\"meta\">\n", "</div>\n");
}

include get_header_path();
echo $layout->header;
if (isset($board) && $board->header)
	include $board->header;
if (isset($template)) {
	$template->set('title', $title);
	$template->render();
} else include "app/views/$controller/$action.php";
if (isset($board) && $board->footer)
	include $board->footer;
echo $layout->footer;
include get_footer_path();
?>
