<?php
require_once 'lib/common.php';

function is_post() {
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}

@list(, $controller, $id, $action) = explode('/', $_SERVER['PATH_INFO']);
if (!is_numeric($id) && $controller != 'board')
	$action = $id;

if (!$action) $action = 'index';
if (!$controller) $controller = 'notice';

$name = cookie_get('name');

@include("actions/$controller.php");
$action_dir = 'actions/' . $controller;
$skin = isset($board->skin) ? $board->skin : 'default';
$_skin_dir = 'skins/' . $skin;
$skin_dir = get_base_path() . $_skin_dir;

@include($action_dir . '/' . $action . '.php');
if (isset($board)) {
	$title = $board->title;
} else {
	$title = "MetaBBS: $controller $action";
}

ob_start();
include($_skin_dir . '/' . $controller . '/' . $action . '.php');
$content = ob_get_contents();
ob_end_clean();

if ($layout = $config->get('global_layout')) {
	include($layout);
} else {
	include($_skin_dir . '/layout.php');
}
?>
