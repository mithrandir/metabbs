<?php
header("Content-Type: text/html; charset=utf-8");

if (!defined('METABBS_BASE_PATH')) {
	define('METABBS_BASE_PATH', substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1));
}

if (!defined('METABBS_DIR')) {
	define('METABBS_DIR', realpath(dirname(__FILE__) . '/..'));
}

if (!isset($_SERVER['REQUEST_URI'])) { // workaround for CGI environment
	$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
}

if (!file_exists(METABBS_DIR . '/metabbs.conf.php')) {
	echo '<h1>Config file not found.</h1><p>Did you install metaBBS? :) <a href="' . METABBS_BASE_PATH . 'install.php">Go to install page &raquo;</a></p>';
	exit;
}

ini_set("include_path", METABBS_DIR . PATH_SEPARATOR . METABBS_DIR . '/lib' . PATH_SEPARATOR . ini_get("include_path"));

function addslashes_deep($v) {
	return is_array($v) ? array_map('addslashes_deep', $v) : addslashes($v);
}
function stripslashes_deep($v) {
	return is_array($v) ? array_map('stripslashes_deep', $v) : stripslashes($v);
}

require_once("core.php");
require_once("request.php");
require_once("i18n.php");
require_once("cookie.php");
require_once("tag_helper.php");
require_once("user_manager.php");
require_once("plugin.php");

$account = UserManager::get_user();
if (!$account) { 
	$account = new Guest;
	$guest = true;
} else {
	$guest = false;
}
$admin = $account->is_admin();
?>
