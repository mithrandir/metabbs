<?php
/**
 * 원문 언어
 */
define('SOURCE_LANGUAGE', 'en');

/**
 * 언어 클래스
 */
class Language {
	var $id;
	var $messages = array();

	/**
	 * 생성자
	 * @param $id 언어 식별자
	 */
	function Language($id) {
		$this->id = $id;
	}

	/**
	 * 번역을 추가한다.
	 * @param $message 원문
	 * @param $translation 번역문
	 */
	function add_translation($message, $translation) {
		$this->messages[$message] = $translation;
	}

	/**
	 * 언어 파일에서 번역을 읽어온다.
	 * @param $path 언어 파일의 경로
	 */
	function load_from_file($path) {
		$lang = array();
		include $path;
		$this->messages += $lang;
	}

	/**
	 * 주어진 문자열을 번역한다.
	 * @param $text 번역할 문자열. printf의 포맷 문자열을 사용할 수 있다.
	 * @param $args 포맷 문자열 인수의 배열 (없어도 됨)
	 * @return 번역된 문자열
	 */
	function translate($text, $args = NULL) {
		if (array_key_exists($text, $this->messages)) {
			$translation = $this->messages[$text];
		} else {
			$translation = $text;
		}

		if (!$args) {
			return $translation;
		} else {
			return vsprintf($translation, $args);
		}
	}
}

/**
 * HTTP Accept-Language 헤더를 분석한다.
 * @param $string 헤더 문자열
 * @return 언어 식별자의 배열
 */
function parse_language_header($string) {
	if (!$string) {
		return array();
	} else {
		$languages = array();
		foreach (explode(',', $string) as $lang) {
			$languages[] = array_shift(explode(';', $lang, 2));
		}
		return $languages;
	}
}

/**
 * 지정한 언어를 불러와 기본 언어로 삼는다.
 * @param $language 언어 식별자
 */
function import_language($language) {
	global $lang;
	$lang = new Language($language);
	if ($language == SOURCE_LANGUAGE) {
		return TRUE;
	}

	$path = METABBS_DIR . '/lib/lang/' . $language . '.php';
	if (file_exists($path)) {
		$lang->load_from_file($path);
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * 기본 언어를 불러온다.
 * always_use_default_language 옵션이 켜져 있을 때는 default_language를
 * 사용하고, 그렇지 않으면 HTTP 헤더를 분석하여 불러오기를 시도한다.
 */
function import_default_language() {
	global $config;
	$default_language = $config->get('default_language', SOURCE_LANGUAGE);
	if ($config->get('always_use_default_language', false)) {
		import_language($default_language);
	} else {
		$langs = parse_language_header($_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$langs[] = $default_language;
		foreach ($langs as $language) {
			if (import_language($language)) break;
		}
	}
}

/**
 * Language::translate()의 단축형
 * 첫 번째 인자는 번역할 문자열, 그 뒤로는 포맷 문자열의 인수가 온다.
 */
function i() {
	global $lang;
	$args = func_get_args();
	$text = array_shift($args);
	return $lang->translate($text, $args);
}
?>
