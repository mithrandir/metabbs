<?php
$parts = explode('/', $_SERVER['PATH_INFO']);
$board = Board::find_by_name($parts[1]);
if (is_numeric(@$parts[2])) {
	$id = @$parts[2];
	$controller = 'show';
} else {
	$controller = @$parts[2];
	$id = @$parts[3];
	if (!$controller) $controller = 'list';
}

/**
 * 전체 url 주소를 생성한다.
 * @param $controller 컨트롤러 명
 * @param $action 액션 명
 * @return http 프로토콜에 맞춘 전체 url
 */
function full_url_for($controller, $action = '') {
	return 'http://'.$_SERVER['HTTP_HOST'].url_for($controller, $action);
}

/**
 * 주소를 생성한다.
 * @param $controller 컨트롤러 명
 * @param $action 액션 명
 * @params 패러미터
 * @return 생성된 url 주소
 */
function url_for($controller, $action = null, $params = array()) {
	if (is_a($controller, 'Board')) {
		$url = $controller->name;
		if ($action) $url .= '/' . $action;
	} else if (is_a($controller, 'Post')) {
		global $board;
		$url = $board->name;
		if ($action) $url .= '/' . $action;
		$url .= '/' . $controller->id;
	} else if (is_a($controller, 'Model')) {
		$url = $controller->get_id() . "/$action";
	} else {
		$url = "$controller/$action";
	}

	if ($params) {
		$_params = array();
		foreach ($params as $key => $value)
			$_params[] = "$key=$value";
		$url .= '?' . implode('&', $_params);
	}

	return METABBS_BASE_URI . $url;
}
?>
