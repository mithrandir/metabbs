<?php
function get_base_uri() {
	static $uri;
	if (!isset($uri)) {
		$uri = get_base_path();
		if (!isset($_GET['redirect'])) {
			$uri .= 'metabbs.php/';
		}
	}
	return $uri;
}
function get_base_path() {
	return dirname($_SERVER['SCRIPT_NAME']) . '/';
}

function chomp(&$str) {
	$str = substr($str, 0, -1);
}
function get_href($model) {
	if (is_string($model)) {
		return $model;
	} else {
		return $model->get_href();
	}
}
function _url_for($controller, $action = null, $params = array()) {
	$url = get_base_uri() . get_href($controller);

	if ($action)
		$url .= '/' . $action;

	if ($params) {
		$url .= "?";
		foreach ($params as $key => $value)
			$url .= "$key=$value&";
		chomp($url);
	}

	return $url;
}
function full_url_for($controller, $action = '') {
	return 'http://'.$_SERVER['HTTP_HOST']._url_for($controller, $action);
}
function url_for($controller, $action = null, $params = array()) {
	if (isset($_GET['search']) && $_SERVER['REQUEST_METHOD'] != 'POST')
		$params['search'] = urlencode($_GET['search']);
	return _url_for($controller, $action, $params);
}
function url_with_referer_for($controller, $action = null, $params = array()) {
	$params['url'] = urlencode($_SERVER['REQUEST_URI']);
	return url_for($controller, $action, $params);
}

function redirect_to($url) {
	header('Location: ' . $url);
	exit;
}
function redirect_back() {
	redirect_to($_GET['url']);
}
?>