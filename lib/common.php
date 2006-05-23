<?php
header("Content-Type: text/html; charset=utf-8");

if (!file_exists('metabbs.conf.php')) {
	echo '<h1>Config file not found.</h1><p>Did you install metaBBS? :) <a href="install.php">Go to install page &raquo;</a></p>';
	exit;
}

set_magic_quotes_runtime(0);

if (@ini_get('register_globals')) {
	foreach ($_REQUEST as $k => $v) {
		unset($$k);
	}
}

if (!get_magic_quotes_gpc()) {
	function addslashes_deep($value) {
		if (is_array($value))
			return array_map('addslashes_deep', $value);
		else
			return addslashes($value);
	}
	$_POST = array_map('addslashes_deep', $_POST);
	$_GET = array_map('addslashes_deep', $_GET);
	$_COOKIE = array_map('addslashes_deep', $_COOKIE);
}

//$metabbs_dir = dirname(__FILE__) . '/../';

require_once("core.php");
require_once("cookie.php");
require_once("tag_helper.php");
require_once("user_manager.php");

$user = UserManager::get_user();
if (!$user) { 
	$user = new Guest;
}

function check_is_installed() {
	if (!file_exists('metabbs.conf.php')) {
		echo '<h1>Config file not found.</h1><p>Did you install metaBBS? :) <a href="install.php">Go to install page &raquo;</a></p>';
		exit;
	}
}

function human_readable_size($size) {
	$units = array(' bytes', 'KB', 'MB', 'GB', 'TB');
	$i = 0;
	while ($size > 1024) {
		$size /= 1024;
		$i++;
	}
	return round($size, 1) . $units[$i];
}
?>
