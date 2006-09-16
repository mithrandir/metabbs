<?php
require_once 'lib/common.php';

function render($template) {
	global $render;
	$render = $template;
}
function print_layout($type) {
	global $config;
	$template = $config->get('global_' . $type);
	if ($template) {
		include($template);
		return true;
	} else {
		return false;
	}
}
function print_header() {
	return print_layout('header');
}
function print_footer() {
	return print_layout('footer');
}

$routes = array(
	'/([a-z]+)/?' => '$1/index/',
	'/([a-z]+)/([^/]+)' => '$1/index/$2',
	'/([a-z]+)/([a-z]+)/(.*)' => '$1/$2/$3'
);

$uri = $_SERVER['PATH_INFO'];
$matched = false;
foreach ($routes as $k => $v) {
	if (preg_match("|^$k$|", $uri, $groups)) {
		list($controller, $action, $id) = parse_internal_uri($v, $groups);
		$matched = true;
		break;
	}
}
if (!$matched) {
	print_notice('Requested URL is not valid.', 'Valid URL format is '.full_url_for("<em>controller</em>", "<em>action</em>").'<br />If you are administrator, go to '.link_to('administration page', 'admin'));
}

$name = cookie_get('name');

$nav = array();

@include("actions/$controller.php");
$action_dir = 'actions/' . $controller;
if (!run_hook_handler($controller, $action)) {
	include($action_dir . '/' . $action . '.php');
}
if (!isset($skin)) {
	$skin = isset($board->skin) ? $board->skin : 'default';
}
$_skin_dir = 'skins/' . $skin;
$skin_dir = METABBS_BASE_PATH . $_skin_dir;

if ($controller == 'board') {
	$title = $board->get_title();
} else if ($controller == 'post') {
	$title = $board->get_title() . " - $post->title";
} else if ($controller == 'user') {
	$title = $user->name;
} else {
	$title = "MetaBBS";
}

if (isset($render)) {
	ob_start();
	include($_skin_dir . '/' . $render . '.php');
	$content = ob_get_contents();
	ob_end_clean();
	include($_skin_dir . '/layout.php');
}
?>
