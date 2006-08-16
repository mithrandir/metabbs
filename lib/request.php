<?php
function is_post() {
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}
function get_requested_page() {
	return (isset($_GET['page']) ? $_GET['page'] : 1);
}

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
	$_POST = addslashes_deep($_POST);
	$_GET = addslashes_deep($_GET);
	$_COOKIE = addslashes_deep($_COOKIE);
}
?>
