<?php
header("Content-Type: text/html; charset=utf-8");

if (!defined('METABBS_BASE_PATH')) {
	define('METABBS_BASE_PATH', substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1));
}

if (!defined('METABBS_DIR')) {
	define('METABBS_DIR', realpath(dirname(__FILE__) . '/..'));
}

if (!file_exists(METABBS_DIR . '/metabbs.conf.php')) {
	echo '<h1>Config file not found.</h1><p>Did you install metaBBS? :) <a href="' . METABBS_BASE_PATH . 'install.php">Go to install page &raquo;</a></p>';
	exit;
}

ini_set("include_path", METABBS_DIR . PATH_SEPARATOR . METABBS_DIR . '/lib' . PATH_SEPARATOR . ini_get("include_path"));

require('compat.php');
require("core.php");
require("request.php");
require("i18n.php");
require("cookie.php");
require("tag_helper.php");
require("user_manager.php");
require("plugin.php");

$account = UserManager::get_user();
if (!$account) { 
	$account = new Guest;
	$guest = true;
} else {
	$guest = false;
}
$admin = $account->is_admin();
?>
