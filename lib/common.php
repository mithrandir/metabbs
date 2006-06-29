<?php
header("Content-Type: text/html; charset=utf-8");

function get_base_path() {
	$path = dirname($_SERVER['SCRIPT_NAME']);
	if ($path != '/' && $path != '\\') {
		$path .= '/';
	}
	return $path;
}

$metabbs_dir = realpath(dirname(__FILE__) . '/..');

if (!file_exists($metabbs_dir . '/metabbs.conf.php')) {
	echo '<h1>Config file not found.</h1><p>Did you install metaBBS? :) <a href="'.get_base_path().'install.php">Go to install page &raquo;</a></p>';
	exit;
}

ini_set("include_path", ini_get("include_path") . ';' . $metabbs_dir);

require_once("core.php");
require_once("request.php");
require_once("i18n.php");
require_once("cookie.php");
require_once("tag_helper.php");
require_once("user_manager.php");

$user = UserManager::get_user();
if (!$user) { 
	$user = new Guest;
}
?>
