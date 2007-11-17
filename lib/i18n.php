<?php
define('SOURCE_LANGUAGE', 'en');

class Language {
	var $id;
	var $messages = array();

	function Language($id) {
		$this->id = $id;
	}

	function add_translation($message, $translation) {
		$this->messages[$message] = $translation;
	}

	function load_from_file($path) {
		$map = Config::_parse($path);
		foreach ($map as $msg => $trans) {
			$this->add_translation($msg, $trans);
		}
	}

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

function import_language($language) {
	global $lang;
	$lang = new Language($language);
	if ($language == SOURCE_LANGUAGE) {
		return TRUE;
	}

	$path = METABBS_DIR . '/lang/' . $language . '.php';
	if (file_exists($path)) {
		$lang->load_from_file($path);
		return TRUE;
	} else {
		return FALSE;
	}
}

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

function i() {
	global $lang;
	$args = func_get_args();
	$text = array_shift($args);
	return $lang->translate($text, $args);
}
?>
