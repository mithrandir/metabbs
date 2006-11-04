<?php
function cookie_get($name) {
	return cookie_is_registered($name) ? $_COOKIE["metabbs_$name"] : '';
}
function cookie_is_registered($name) {
	return isset($_COOKIE["metabbs_$name"]);
}
function cookie_register($name, $value) {
	setcookie("metabbs_$name", $value, time() + 60*60*24*30, '/');
}
function cookie_unregister($name) {
	setcookie("metabbs_$name", "", time() - 3600, '/');
}

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
