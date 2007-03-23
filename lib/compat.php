<?php
if (!isset($_SERVER['REQUEST_URI'])) { // workaround for CGI environment
	$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
}

if (ini_get('magic_quotes_runtime')) {
	set_magic_quotes_runtime(0);
}

/**
 * 배열과 변수 모두 슬래쉬를 추가한다.
 * @param $v 입력. 변수든 배열이든 상관없다.
 */
function addslashes_deep($v) {
	return is_array($v) ? array_map('addslashes_deep', $v) : addslashes($v);
}

/**
 * 배열과 변소 모두 슬래쉬를 제거한다.
 * @param $v. 변수든 배열이든 상관없다.
 */
function stripslashes_deep($v) {
	return is_array($v) ? array_map('stripslashes_deep', $v) : stripslashes($v);
}

if (ini_get('register_globals')) {
	foreach ($_REQUEST as $k => $v) {
		unset($$k);
	}
}

if (get_magic_quotes_gpc()) {
	$_POST = stripslashes_deep($_POST);
	$_GET = stripslashes_deep($_GET);
	$_COOKIE = stripslashes_deep($_COOKIE);
}

if (function_exists('mb_substr')) {
	function utf8_strcut($str, $len) {
		if (mb_strlen($str, 'UTF-8') > $len)
			return mb_substr($str, 0, $len, 'UTF-8') . '...';
		else
			return $str;
	}
} else if (function_exists('iconv_substr')) {
	function utf8_strcut($str, $len) {
		if (iconv_strlen($str, 'UTF-8') > $len)
			return iconv_substr($str, 0, $len, 'UTF-8') . '...';
		else
			return $str;
	}
} else {
	function utf8_strcut($str, $len) {
		return preg_replace('/^(.{'.$len.'}).+$/su', "$1...", $str);
	}
}

if (!function_exists('array_combine')) {
	function array_combine($keys, $vals) {
		$r = array();
		foreach ($keys as $i => $k) {
			$r[$k] = $vals[$i];
		}
		return $r;
	}
}
?>
