<?php
/**
 * 쿠기를 가져온다.
 * @return 쿠키가 존재하면 가져오고 없다면 ''를 리턴한다.
 */
function cookie_get($name) {
	return cookie_is_registered($name) ? $_COOKIE["metabbs_$name"] : '';
}

/**
 * 쿠키가 등록되었는지 확인한다.
 * @return 해당 쿠키의 존재여부를 참 거짓으로 반환한다.
 */
function cookie_is_registered($name) {
	return isset($_COOKIE["metabbs_$name"]);
}

/**
 * 쿠키를 등록한다.
 * @param $name 쿠키의 이름
 * @param $value 저장할 값
 * @param $instance 참이면 0을 거짓이면 한달을 설정한다.
 */
function cookie_register($name, $value, $instant = false) {
	setcookie("metabbs_$name", $value, $instant ? 0 : time() + 60*60*24*30, '/');
}

/**
 * 쿠키를 해제한다.
 * @param $name 쿠키의 이름
 */
function cookie_unregister($name) {
	setcookie("metabbs_$name", "", time() - 3600, '/');
}
?>
