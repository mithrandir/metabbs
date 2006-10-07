<?php
if (!defined('METABBS_BASE_URI')) {
	if (isset($_SERVER['REDIRECT_URL'])) {
		define('METABBS_BASE_URI', METABBS_BASE_PATH);
	} else {
		define('METABBS_BASE_URI', $_SERVER['SCRIPT_NAME'] . '/');
	}
}

function parse_internal_uri($str, $groups) {
	foreach ($groups as $k => $v) {
		$str = str_replace('$' . $k, $v, $str);
	}
	return explode('/', $str, 3);
}

function get_base_uri() {
	return METABBS_BASE_URI;
}
function _url_for($controller, $action = null, $params = array()) {
	$id = '';
	if (is_a($controller, 'Model')) {
		$id = $controller->get_id();
		$controller = $controller->get_model_name();
	}
	$uri = array($controller);
	if ($action) $uri[] = $action;
	$uri[] = urlencode($id);
	$url = get_base_uri() . implode('/', $uri);

	if ($params) {
		$_params = array();
		foreach ($params as $key => $value)
			$_params[] = "$key=$value";
		$url .= '?' . implode('&', $_params);
	}

	return $url;
}

function full_url_for($controller, $action = '') {
	return 'http://'.$_SERVER['HTTP_HOST']._url_for($controller, $action);
}

function url_for($controller, $action = null, $params = array()) {
	if (isset($_GET['search']) && $_GET['search']) {
		foreach ($_GET['search'] as $k => $v) {
			if ($v) $params["search[$k]"] = urlencode($v);
		}
	}
	return _url_for($controller, $action, $params);
}
function url_with_referer_for($controller, $action = null, $params = array()) {
	$params['url'] = urlencode($_SERVER['REQUEST_URI']);
	if (isset($GLOBALS['board'])) {
		$params['board_id'] = $GLOBALS['board']->id;
	}
	return url_for($controller, $action, $params);
}

function redirect_to($url) {
	header('Location: ' . $url);
	exit;
}

function redirect_back() {
	if (isset($_GET['url'])) {
		redirect_to($_GET['url']);
	} else {
		redirect_to(url_for(""));
	}
}

?>
