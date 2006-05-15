<?php
function get_uri_manager() {
    global $um;
    if (!isset($um)) {
        if (!isset($_GET['redirect'])) {
            $um = new URIManager;
        } else {
            $um = new RewrittenURIManager;
        }
    }
    return $um;
}
function get_base_uri() {
    static $uri;
    $um = get_uri_manager();
    if (!isset($uri)) {
        $uri = $um->get_base_uri();
    }
    return $uri;
}
function get_base_path() {
    $um = get_uri_manager();
    return $um->get_base_path();
}
function get_path_info() {
	$um = get_uri_manager();
	return $um->get_path_info();
}
function trim_query_string($path) {
    $pos = strpos($path, '?');
    return (!$pos) ? $path : substr($path, 0, $pos);
}
function full_url_for($controller, $action = '') {
    return 'http://'.$_SERVER['HTTP_HOST']._url_for($controller, $action);
}
function chomp(&$str) {
    $str = substr($str, 0, -1);
}
function get_href($model) {
    return $model->get_href();
}
function _url_for($controller, $action = null, $params = array()) {
    $url = get_base_uri();
    if (is_string($controller))
        $url .= $controller;
    else
        $url .= $controller->get_href();

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
function url_for($controller, $action = null, $params = array(), $append_url = false) {
    if ($append_url)
        $params['url'] = urlencode($_SERVER['REQUEST_URI']);

    if (isset($_GET['search']) && $_SERVER['REQUEST_METHOD'] != 'POST')
        $params['search'] = urlencode($_GET['search']);

    return _url_for($controller, $action, $params);
}
function redirect_to($url) {
	header('Location: ' . $url);
	exit;
}

class URIManager
{
    function get_base_uri() {
        return $this->get_base_path() . 'metabbs.php/';
    }
    function get_base_path() {
        return dirname($_SERVER['SCRIPT_NAME']) . '/';
    }
    function get_path_info() {
        return $_SERVER['PATH_INFO'];
    }
}

class RewrittenURIManager extends URIManager
{
    function get_base_uri() {
        return $this->get_base_path();
    }
}

class ExternalURIManager extends URIManager
{
    function get_base_path() {
        global $base_url;
        return $base_url;
    }
}
?>
