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

//$metabbs_dir = dirname(__FILE__) . '/../';

require_once("core.php");
require_once("cookie.php");

if (cookie_is_registered('user') && cookie_is_registered('password')) {
	$user = User::auth(cookie_get('user'), cookie_get('password'));
} else {
	$user = new Guest;
}

function is_admin() {
	global $user;
	return ($user->level == 255);
}

function check_is_installed() {
	if (!file_exists('metabbs.conf.php')) {
		echo '<h1>Config file not found.</h1><p>Did you install metaBBS? :) <a href="install.php">Go to install page &raquo;</a></p>';
		exit;
	}
}

function _addslashes(&$str) {
	$str = addslashes($str);
}
function addslashes_deep(&$array) {
	if (is_array($array)) {
		@array_walk($array, '_addslashes');
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
