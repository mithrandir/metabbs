<?php
header("Content-Type: text/html; charset=utf-8");

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

function addslashes_deep(&$array) {
	if (is_array($array)) {
		@array_walk($array, 'addslashes');
	}
}
?>
