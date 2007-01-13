q
<?php
require 'lib/common.php';

function render($template) {
	global $render;
	$render = $template;
}
function is_system_view($skin) {
    return $skin{0} == '_';
}
function get_layout_path($type) {
	global $config, $_skin_dir, $__skin;
	$layout = $config->get('global_' . $type);
	if (is_system_view($__skin) || !$layout)
		return $_skin_dir . '/' . $type . '.php';
	else
		return $layout;
}

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
@include("actions/$controller.php");
$action_dir = 'actions/' . $controller;
if (!run_hook_handler($controller, $action)) {
	include($action_dir . '/' . $action . '.php');
}
if (!isset($skin)) {
	$skin = isset($board->skin) ? $board->skin : 'default';
}
$__skin = $skin;
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
