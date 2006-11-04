<?php
require_once 'lib/common.php';

function render($template) {
	global $render;
	$render = $template;
}
function is_default_skin($skin) {
    return $skin{0} == '_';
}
function get_layout_path($type) {
	global $config, $_skin_dir, $skin;
	$default = $_skin_dir . '/' . $type . '.php';
	if (is_default_skin($skin))
		return $default;
	else
		return $config->get('global_' . $type, $default);
}

class MetaRouter extends Router {
	var $routes = array(
		'/(attachment)/([0-9]+)_.*' => 'controller',
		'/([a-z]+)(?:/([^/]*))?' => 'controller',
		'/([a-z]+)/([a-z]+)/(.*)' => 'full'
	);
	var $action = 'index';

	function controller($groups) {
		@list(, $this->controller, $this->id) = $groups;
	}
	function full($groups) {
		list(, $this->controller, $this->action, $this->id) = $groups;
	}
}

$router = new MetaRouter;
if ($router->parse_uri($_SERVER['PATH_INFO'])) {
	$controller = $router->controller;
	$action = $router->action;
	$id = $router->id;
} else {
	print_notice('Requested URL is not valid.', 'Valid URL format is '.full_url_for("<em>controller</em>", "<em>action</em>").'<br />If you are administrator, go to '.link_to('administration page', 'admin'));
}

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
	echo "<div id=\"meta\">\n";
	include($_skin_dir . '/' . $render . '.php');
	echo "</div>\n";
	include(get_layout_path('footer'));
}
?>
