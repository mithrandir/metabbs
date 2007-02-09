<?php
/**
 * 화면에 출력될 글구를 해당 언어로 변경해준다.
 * @param 첫번째 인자는 키로 사용되고 이후의 인자는 printf의 인자들로 인식된다.
 * @return 해당 언어로 변경된 문자열을 리턴한다.
 */
function i() {
	global $lang;
	if (func_num_args() > 1) {
		$args = func_get_args();
		return vsprintf($lang->get(array_shift($args)), $args);
	} else {
		$arg = func_get_arg(0);
		return $lang->get($arg);
	}
}

/**
 * 기본 언어
 */
class DefaultLanguage {
	/**
	 * 기본 언어는 키와 값을 동일하게 처리한다.
	 * @param $text 출력할 키 문자열
	 * @return $text 문자열과 동일한 문자열
	 */
	function get($text) {
		return $text;
	}
}

/**
 * 국제화 대응 클래스
 */
class I18N {
	/**
	 * 생성자. 해당 언어 파일을 읽어 설정한다.
	 * @param $lang 언어
	 */
	function I18N($lang) {
		$this->lang = $lang;
		$this->messages = Config::_parse(METABBS_DIR . "/lang/$lang.php");
	}

	/**
	 * 키에 해당하는 문자를 읽어온다.
	 * @param $text 키 문자열
	 * @return 해당 언어의 문자열을 리턴한다 없으면 키 문자열을 그대로 리턴.
	 */
	function get($text) {
		return array_key_exists($text, $this->messages) ? $this->messages[$text] : $text;
	}

	/**
	 * 해당 언어 파일을 읽어 국재화 객체 인스턴스를 반환한다.
	 * @param $lang 언어
	 * @return 성공한 경우 국제화 객체의 인스턴스. 실패한 경우 null을 리턴한다.
	 */
	function import($lang) {
		if ($lang == 'en') {
			return new DefaultLanguage;
		} else if (file_exists(METABBS_DIR . '/lang/'.$lang.'.php')) {
			return new I18N($lang);
		} else {
			return false;
		}
	}
}

$default_language = $config->get('default_language', 'en');
if ($config->get('always_use_default_language', false)) {
	$lang = I18N::import($default_language);
} else {
	$langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
	$langs[] = $default_language;
	foreach ($langs as $langcode) {
		list($langcode) = explode(';', $langcode, 2);
		if ($lang = I18N::import($langcode)) break;
	}
}
?>
