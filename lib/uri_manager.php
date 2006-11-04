<?php
if (!defined('METABBS_BASE_URI')) {
	if (isset($_SERVER['REDIRECT_URL'])) {
		define('METABBS_BASE_URI', METABBS_BASE_PATH);
	} else {
		define('METABBS_BASE_URI', $_SERVER['SCRIPT_NAME'] . '/');
	}
}

class Router {
	var $routes = array();

	function parse_uri($uri) {
		foreach ($this->routes as $pattern => $method) {
			if (preg_match('|^'.$pattern.'$|', $uri, $groups)) {
				$this->$method($groups);
				return true;
			}
		}
		return false;
	}
}

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

function full_url_for($controller, $action = '') {
	return 'http://'.$_SERVER['HTTP_HOST']._url_for($controller, $action);
}

function url_for($controller, $action = null, $params = array()) {
	if (isset($_GET['search']) && $_GET['search']) {
		foreach ($_GET['search'] as $k => $v) {
			$params["search[$k]"] = urlencode($v);
		}
	}
	return _url_for($controller, $action, $params);
}
function url_with_referer_for($controller, $action = null, $params = array()) {
	if (!isset($_GET['url'])) {
		$params['url'] = urlencode($_SERVER['REQUEST_URI']);
	} else {
		$params['url'] = urlencode($_GET['url']);
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
		redirect_to($_SERVER['HTTP_REFERER']);
	}
}

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
