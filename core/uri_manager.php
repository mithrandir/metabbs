<?php
if (!defined('METABBS_BASE_URI')) {
	if (isset($_SERVER['REDIRECT_URL']) ||
		$config->get('force_fancy_url', false)) {
		define('METABBS_BASE_URI', METABBS_BASE_PATH);
	} else {
		define('METABBS_BASE_URI', $_SERVER['SCRIPT_NAME'] . '/');
	}
}

/**
 * 해당 컨트롤러와 액션에 맞는 url의 내용을 생성한다. 이 함수가 구체적인 url을 만든다.
 * @param $controller 컨트롤러
 * @param $action 액션
 * @param $params 전달할 패러미터
 * @return 생성된 URL 주소의 문자열
 */
function _url_for($controller, $action = null, $params = null) {
	$url = METABBS_BASE_URI;
	if (is_string($controller)) {
		$url .= $controller . '/';
		if ($action) $url .= $action . '/';
	} else {
		$url .= $controller->model . '/';
		if ($action) $url .= $action . '/';
		$url .= urlencode($controller->get_id());
	}

	if ($params) $url .= query_string_for($params);

	return $url;
}

function query_string_for($params) {
	$_params = array();

	foreach ($params as $key => $value) {
		$_params[] = "$key=$value";
	}
		return '?' . implode('&', $_params);
}

/**
 * 전체 url 주소를 생성한다.
 * @param $controller 컨트롤러 명
 * @param $action 액션 명
 * @return http 프로토콜에 맞춘 전체 url
 */
function full_url_for($controller, $action = '') {
	return METABBS_HOST_URL._url_for($controller, $action);
}

/**
 * _url_for를 호출하여 일반적인 주소를 만든다.
 * @param $controller 컨트롤러 명
 * @param $action 액션 명
 * @params 패러미터
 * @return 생성된 url 주소
 */
function url_for($controller, $action = null, $params = array()) {
	if (is_a($controller, 'Board')) {
		$u = METABBS_BASE_URI . urlencode($controller->get_id());
		if ($action) $u .= '/' . $action;
		if ($params) $u .= query_string_for($params);
		return $u;
	} elseif (is_a($controller, 'Post')) {
		$board = $controller->get_board();
		$u = url_for($board) . '/' . $controller->get_id();
		if ($action) $u .= '/' . $action;
		if ($params) $u .= query_string_for($params);
		return $u;
	} elseif (is_a($controller, 'User')) {
		$u = METABBS_BASE_URI . '~' . urlencode($controller->get_id());
		if ($params) $u .= query_string_for($params);
		return $u;
	} elseif (is_a($controller, 'Attachment')) {
		$u = url_for($controller->get_post()) . '/attachments/' . urlencode($controller->get_id());
		if ($params) $u .= query_string_for($params);
		return $u;
	} else {
		return _url_for($controller, $action, $params);
	}
}
/**
 * 예외적 상항에 따른 url_for
 */
function url_for_list($controller, $action , $params = null) {
	$url = METABBS_BASE_URI;
	$url .= $controller . '/'. $action;
	if ($params) $url .= query_string_for($params);

	return $url;
}
/**
 * _GET, _POST, _COOKIE 변수 통채로 가져오는 함수
 */
function get_params($defaults = null, $overwrite = false, $super_globals = array('_GET', '_POST', '_COOKIE'))
{
    $ret = array();

    foreach($super_globals as $sg)
        foreach($GLOBALS[$sg] as $k=>$v)
            $ret[$k] = $v;

    if($defaults) foreach($defaults as $k=>$v)
        if(!isset($ret[$k]))
            $ret[$k] = $v;

    if($overwrite)
        $_REQUEST = $ret;

    return $ret;
}

function get_search_params() {
	$params = array();
	$keys = array();
	if (isset($_GET['category']) && $_GET['category'] !== '') {
		$keys[] = 'category';
	}
	if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
		$keys[] = 'keyword';
		$keys[] = 'title';
		$keys[] = 'body';
		$keys[] = 'comment';
		$keys[] = 'author';
		$keys[] = 'tag';
	}
	if ($keys) $keys[] = 'page';
		
	foreach ($keys as $k) {
		if ($k == 'page')
			$params['page'] = get_requested_page();
		else if (isset($_GET[$k]) && $_GET[$k] !== '')
			$params[$k] = urlencode($_GET[$k]);
	}
	return $params;
}

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
