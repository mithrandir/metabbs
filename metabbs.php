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

$title = 'MetaBBS';
@include("app/controllers/$controller.php");
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
$__skin = $skin;
$_skin_dir = 'skins/' . $skin;
$skin_dir = METABBS_BASE_PATH . $_skin_dir;

foreach (get_header_paths() as $header) include $header;
echo "<div id=\"meta\">\n";
include "app/views/$controller/$action.php";
echo "</div>\n";
foreach (get_footer_paths() as $footer) include $footer;
?>
