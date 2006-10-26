<?php
require_once 'lib/common.php';

function render($template) {
	global $render;
	$render = $template;
}
function get_layout_path($type) {
	global $config, $_skin_dir, $skin;
	$default = $_skin_dir . '/' . $type . '.php';
	if ($skin == '_admin')
		return $default;
	else
		return $config->get('global_' . $type, $default);
}

$routes = array(
	'/([a-z]+)/?' => '$1/index/',
	'/attachment/([0-9]+)_.*' => 'attachment/index/$1',
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

$nav = array();

$title = 'MetaBBS';
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

if (isset($render)) {
	include(get_layout_path('header'));
	echo '<div id="meta">';
	include($_skin_dir . '/' . $render . '.php');
	echo '</div>';
	include(get_layout_path('footer'));
}
?>
