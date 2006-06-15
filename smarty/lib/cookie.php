<?php
function cookie_get($name) {
	if (cookie_is_registered($name)) {
		return $_COOKIE["metabbs_$name"];
	} else {
		return "";
	}
}
function cookie_is_registered($name) {
	return isset($_COOKIE["metabbs_$name"]);
}
function cookie_register($name, $value) {
	setcookie("metabbs_$name", $value, time() + 60*60*24*30, get_base_path());
}
function cookie_unregister($name) {
	setcookie("metabbs_$name", "", time() - 3600, get_base_path());
}
?>
