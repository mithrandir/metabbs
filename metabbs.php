<?php
require_once 'lib/common.php';

function is_post() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

$tmp = explode('/', $_SERVER['PATH_INFO']);
$params = $_GET + $_POST;

if ($tmp[1] == 'board') {
	$controller = 'board';
	$id = $tmp[2];
	$action = isset($tmp[3]) ? $tmp[3] : 'index';
} else {
	$controller = $tmp[1];
	if (@is_numeric($tmp[2])) {
		$id = $tmp[2];
		$action = isset($tmp[3]) ? $tmp[3] : 'index';
	} else {
		$action = isset($tmp[2]) ? $tmp[2] : 'index';
	}
}

if (!$controller) {
    $controller = 'notice';
}

if (cookie_is_registered('name')) {
	$name = cookie_get('name');
} else {
	$name = '';
}

@include("actions/$controller.php");
$action_dir = 'actions/' . $controller;
$skin = isset($board->skin) ? $board->skin : 'default';
$_skin_dir = 'skins/' . $skin . '/';
$skin_dir = get_base_path() . $_skin_dir;

@include($action_dir . '/' . $action . '.php');
if (isset($board)) {
    $title = $board->title;
} else {
    $title = "MetaBBS: $controller $action";
}

$content = $_skin_dir . $controller . '/' . $action . '.php';

if ($layout = $config->get('global_layout')) {
	include($layout);
} else {
	include($_skin_dir . '/layout.php');
}
?>
