<?php
function is_post() {
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}
function get_requested_page() {
	return isset($_GET['page']) ? $_GET['page'] : 1;
}
function get_upload_size_limit() {
	return min(ini_get('post_max_size'), ini_get('upload_max_filesize'));
}

if (@ini_get('register_globals')) {
	foreach ($_REQUEST as $k => $v) {
		unset($$k);
	}
}

if (get_magic_quotes_gpc()) {
	$_POST = stripslashes_deep($_POST);
	$_GET = stripslashes_deep($_GET);
	$_COOKIE = stripslashes_deep($_COOKIE);
}
?>
