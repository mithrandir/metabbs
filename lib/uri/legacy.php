<?php
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

if ($controller == 'board') {
	$board = Board::find_by_name($id);
	if ($action == 'index') $controller = 'list';
	else $controller = $action;
} else if ($controller == 'post') {
	$post = Post::find($id);
	$board = $post->get_board();
	$controller = 'view';
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
	if (is_a($controller, 'Model')) {
		$url .= $controller->model . '/';
		if ($action) $url .= $action . '/';
		$url .= $controller->get_id();
	} else {
		$url .= $controller . '/';
		if ($action) $url .= $action . '/';
	}

	if ($params) {
		$_params = array();
		foreach ($params as $key => $value)
			$_params[] = "$key=$value";
		$url .= '?' . implode('&', $_params);
	}

	return $url;
}

/**
 * 전체 url 주소를 생성한다.
 * @param $controller 컨트롤러 명
 * @param $action 액션 명
 * @return http 프로토콜에 맞춘 전체 url
 */
function full_url_for($controller, $action = '') {
	return 'http://'.$_SERVER['HTTP_HOST']._url_for($controller, $action);
}

/**
 * _url_for를 호출하여 일반적인 주소를 만든다.
 * @param $controller 컨트롤러 명
 * @param $action 액션 명
 * @params 패러미터
 * @return 생성된 url 주소
 */
function url_for($controller, $action = null, $params = array()) {
	if (isset($_GET['search']) && $_GET['search']) {
		foreach ($_GET['search'] as $k => $v) {
			if ($v) $params["search[$k]"] = urlencode($v);
		}
	}
	return _url_for($controller, $action, $params);
}
?>
