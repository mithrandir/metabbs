<?php
header("Content-Type: text/html; charset=utf-8");

if (!isset($base_path)) {
	$base_path = dirname($_SERVER['SCRIPT_NAME']);
	if ($base_path != '/' && $base_path != '\\') {
		$base_path .= '/';
	}
}
function get_base_path() {
	return $GLOBALS['base_path'];
}

$metabbs_dir = realpath(dirname(__FILE__) . '/..');

if (!isset($_SERVER['REQUEST_URI'])) { // workaround for CGI environment
	$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
}

if (!file_exists($metabbs_dir . '/metabbs.conf.php')) {
	echo '<h1>Config file not found.</h1><p>Did you install metaBBS? :) <a href="'.get_base_path().'install.php">Go to install page &raquo;</a></p>';
	exit;
}

ini_set("include_path", ini_get("include_path") . PATH_SEPARATOR . $metabbs_dir . PATH_SEPARATOR . $metabbs_dir . '/lib');

require_once("core.php");
require_once("request.php");
require_once("i18n.php");
require_once("cookie.php");
require_once("tag_helper.php");
require_once("user_manager.php");

$account = UserManager::get_user();
if (!$account) { 
	$account = new Guest;
}
?>
