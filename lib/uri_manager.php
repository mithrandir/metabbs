<?php
function get_base_uri() {
	static $uri;
	if (!isset($uri)) {
		$uri = METABBS_BASE_PATH;
		if (!isset($_GET['redirect'])) {
			$uri .= 'metabbs.php/';
		}
	}
	return $uri;
}

function _url_for($controller, $action = null, $params = array()) {
	if (is_a($controller, 'Model')) {
		$uri = array($controller->get_model_name(), $controller->get_id());
	} else {
		$uri = array($controller, '');
	}
	if ($action) $uri = array($uri[0], $action, $uri[1]);
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
