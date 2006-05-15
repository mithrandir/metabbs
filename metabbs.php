<?php
require_once 'common.php';

$tmp = explode('/', $_SERVER['PATH_INFO']);
$params = $_GET + $_POST;

if ($tmp[1] == 'board') {
	$controller = 'board';
	$id = $tmp[2];
	$action = isset($tmp[3]) ? $tmp[3] : 'index';
} else {
	$controller = $tmp[1];
	if (is_numeric($tmp[2])) {
		$id = $tmp[2];
		$action = isset($tmp[3]) ? $tmp[3] : 'index';
	} else {
		$action = $tmp[2];
	}
}

function url_for($controller, $action = '') {
    $url = $controller->get_href();
    if ($action) {
        $url .= '/' . $action;
    }
    return $url;
}

function redirect_to($url) {
	header('Location: ' . $url);
	exit;
}

if (session_is_registered('name')) {
	$name = $_SESSION['name'];
} else {
	$name = '';
}

$action_dir = 'actions/' . $controller;
@include($action_dir . '/_base.php');
include($action_dir . '/' . $action . '.php');
if (!isset($board->skin)) {
	$board->skin = 'default';
}

$_skin_dir = 'skins/' . $board->skin . '/';
$skin_dir = get_base_path() . $_skin_dir;
ob_start();
include($_skin_dir . $controller . '/' . $action . '.php');
$content = ob_get_contents();
ob_end_clean();

if ($layout = $config->get('global_layout')) {
	include($layout);
} else {
	include($_skin_dir . '/layout.php');
}
?>
