<?php
header("Content-Type: text/html; charset=utf-8");

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

function addslashes_deep($v) {
	return is_array($v) ? array_map('addslashes_deep', $v) : addslashes($v);
}

function stripslashes_deep($v) {
	return is_array($v) ? array_map('stripslashes_deep', $v) : stripslashes($v);
}
?>
