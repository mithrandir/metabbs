<?php
function is_post() {
	return $_SERVER['REQUEST_METHOD'] == 'POST';
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
?>
