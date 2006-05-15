<?php
function get_uri_manager() {
    static $um;
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
    $um = get_uri_manager();
    return $um->get_base_uri();
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
?>
