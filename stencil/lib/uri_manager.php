<?php
if (!defined('METABBS_BASE_URI')) {
	if (isset($_SERVER['REDIRECT_URL'])) {
		define('METABBS_BASE_URI', METABBS_BASE_PATH);
	} else {
		define('METABBS_BASE_URI', $_SERVER['SCRIPT_NAME'] . '/');
	}
}

//require 'lib/uri/legacy.php';
require 'lib/uri/simple.php';

/**
 * 리퍼러 정보를 포함한 url을 생성한다.
 * @param $controller 컨트롤러 명
 * @param $action 액션 명칭
 * @param $params 패러미터
 * @return 리퍼러 정보를 포함한 url의 스트링
 */
function url_with_referer_for($controller, $action = null, $params = array()) {
	if (!isset($_GET['url'])) {
		$params['url'] = urlencode($_SERVER['REQUEST_URI']);
	} else {
		$params['url'] = urlencode($_GET['url']);
	}
	return url_for($controller, $action, $params);
}

/**
 * 지정한 주소로 리다이렉트한다.
 * @param $url 이동할 주소
 */
function redirect_to($url) {
	header('Location: ' . $url);
	exit;
}

/**
 * 리퍼러나 지정된 주소를 기초로 뒤로 돌아간다.
 */
function redirect_back() {
	if (isset($_GET['url'])) {
		redirect_to($_GET['url']);
	} else {
		redirect_to($_SERVER['HTTP_REFERER']);
	}
}
?>
