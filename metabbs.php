<?php
require 'lib/common.php';

/**
 * 스킨이 관리자용인지 확인합니다.
 * @param $skin 스킨 이름
 * @return 관리자용 여부
 */
function is_system_view($skin) {
    return $skin{0} == '_';
}

/**
 * 레이아웃을 위한 파일 경로를 알아옵니다.
 * @param $type 화면에 출력할 타입
 * @return 파일 경로
 */
function get_layout_path($type) {
	global $config, $_skin_dir, $__skin;
	$layout = $config->get('global_' . $type);
	if (is_system_view($__skin) || !$layout)
		return 'app/views/default_' . $type . '.php';
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
if ($skin == '_admin') {
	$style_dir = METABBS_BASE_PATH . 'skins/_admin';
}
$__skin = $skin;
$_skin_dir = 'skins/' . $skin;
$skin_dir = METABBS_BASE_PATH . $_skin_dir;

include(get_layout_path('header'));
include($_skin_dir . '/header.php');
echo "<div id=\"meta\">\n";
include("app/views/$controller/$action.php");
echo "</div>\n";
include($_skin_dir . '/footer.php');
include(get_layout_path('footer'));
?>
