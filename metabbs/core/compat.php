<?php
/**
 * CGI 환경을 위한 처리
 */
if (!isset($_SERVER['REQUEST_URI'])) {
	$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
}

/**
 * magic_quotes_runtime 설정 값을 끈다.
 */
if (ini_get('magic_quotes_runtime')) {
	set_magic_quotes_runtime(0);
}

/**
 * 배열의 원소에 재귀적으로 addslashes() 함수를 적용한다.
 * @param $v 처리할 배열 또는 문자열
 */
function addslashes_deep($v) {
	return is_array($v) ? array_map('addslashes_deep', $v) : addslashes($v);
}

/**
 * 배열의 원소에 재귀적으로 stripslashes() 함수를 적용한다.
 * @param $v 처리할 배열 또는 문자열
 */
function stripslashes_deep($v) {
	return is_array($v) ? array_map('stripslashes_deep', $v) : stripslashes($v);
}

/**
 * register_globals 설정 값이 켜져 있을 때 등록된 전역 변수를 모두 해제한다.
 */
if (ini_get('register_globals')) {
	foreach ($_REQUEST as $k => $v) {
		unset($$k);
	}
}

/**
 * magic_quotes_gpc 설정 값이 켜져 있을 때 요청 변수에 stripslashes() 함수를 적용한다.
 */
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

/**
 * PHP 4를 위해 PHP 5 객체 복제 흉내내기
 */
if (version_compare(phpversion(), '5.0') < 0) {
	eval('function clone($object) { return $object; }');
}

/**
 * PHP 4에 없는 함수들 추가
 */
if(!function_exists('scandir')) {
    function scandir($dir, $sortorder = 0) {
        if(is_dir($dir) && $dirlist = @opendir($dir)) {
            while(($file = readdir($dirlist)) !== false) {
                $files[] = $file;
            }
            closedir($dirlist);
            ($sortorder == 0) ? asort($files) : rsort($files); // arsort was replaced with rsort
            return $files;
        } else return false;
    }
} 

/*
if(!function_exists('array_diff_key')){ 
	function array_diff_key(){ 
		$arrs = func_get_args(); 
		$result = array_shift($arrs); 
		foreach ($arrs as $array) { 
			foreach ($result as $key => $v) { 
				if (array_key_exists($key, $array))
					unset($result[$key]); 
			} 
		} 
		return $result; 
	} 
} 
*/
?>
