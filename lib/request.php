<?php
function is_post() {
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}
function get_requested_page() {
	return isset($_GET['page']) ? $_GET['page'] : 1;
}

if (@ini_get('register_globals')) {
	foreach ($_REQUEST as $k => $v) {
		unset($$k);
	}
}

if (!get_magic_quotes_gpc()) {
	$_POST = addslashes_deep($_POST);
	$_GET = addslashes_deep($_GET);
	$_COOKIE = addslashes_deep($_COOKIE);
}

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
