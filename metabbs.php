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
function print_header() {
	global $config;
	$header = $config->get('global_header');
	if ($header) {
		include($header);
		return true;
	} else {
		return false;
	}
}
function print_footer() {
	global $config;
	$footer = $config->get('global_footer');
	if ($footer) {
		include($footer);
		return true;
	} else {
		return false;
	}
}

@list(, $controller, $id, $action) = explode('/', $_SERVER['PATH_INFO']);
if (!is_numeric($id) && $controller != 'board') {
	$action = $id;
	unset($id);
}

if (!$action) $action = 'index';
if (!$controller) {
	print_notice('Requested URL is not valid.', 'Valid URL format is '.full_url_for("<em>controller</em>", "<em>action</em>").'<br />If you are administrator, go to '.link_to('administration page', 'admin'));
}

$name = cookie_get('name');

$nav = array();

include("actions/$controller.php");
$action_dir = 'actions/' . $controller;
include($action_dir . '/' . $action . '.php');
if (!isset($skin)) {
	$skin = isset($board->skin) ? $board->skin : 'default';
}
$_skin_dir = 'skins/' . $skin;
$skin_dir = get_base_path() . $_skin_dir;

if ($controller == 'board') {
	$title = $board->title;
} else if ($controller == 'post') {
	$title = "$board->title - $post->title";
} else if ($controller == 'user') {
	$title = $user_->name;
} else {
	$title = "MetaBBS";
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
