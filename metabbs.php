<?php
require_once 'lib/common.php';

function render($template) {
	global $render;
	$render = $template;
}
function get_skins() {
	$skins = array();
	$dir = opendir('skins');
	while ($file = readdir($dir)) {
		if ($file{0} != '_' && $file{0} != '.' && is_dir("skins/$file")) {
			$skins[] = $file;
		}
	}
	closedir($dir);
	return $skins;
}

@list(, $controller, $id, $action) = explode('/', $_SERVER['PATH_INFO']);
if (!is_numeric($id) && $controller != 'board') {
	$action = $id;
	unset($id);
}

if (!$action) $action = 'index';
if (!$controller) $controller = 'notice';

$name = cookie_get('name');

$nav = array();

@include("actions/$controller.php");
$action_dir = 'actions/' . $controller;
@include($action_dir . '/' . $action . '.php');
if (!isset($skin)) {
	$skin = isset($board->skin) ? $board->skin : 'default';
}
$_skin_dir = 'skins/' . $skin;
$skin_dir = get_base_path() . $_skin_dir;

if (isset($board) && is_a($board, 'Board')) {
	$title = $board->title;
	if (isset($post) && $post->title) {
		$title .= ' - ' . $post->title;
	}
} else if (isset($user_) && is_a($user_, 'User')) {
	$title = $user_->name;
} else {
	$title = "MetaBBS: $controller $action";
}

if (isset($render)) {
	ob_start();
	include($_skin_dir . '/' . $render . '.php');
	$content = ob_get_contents();
	ob_end_clean();
	if ($layout = $config->get('global_layout') && $controller != 'admin') {
		include($layout);
	} else {
		include($_skin_dir . '/layout.php');
	}
}
?>
