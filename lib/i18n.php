<?php
function i() {
	global $lang;
	$args = func_get_args();
	return vsprintf($lang->get(array_shift($args)), $args);
}

class DefaultLanguage {
	function get($text) {
		return $text;
	}
}
class I18N {
	function I18N($lang) {
		$this->lang = $lang;
		$this->messages = Config::_parse(METABBS_DIR . "/lang/$lang.php");
	}
	function get($text) {
		return array_key_exists($text, $this->messages) ? $this->messages[$text] : $text;
	}
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

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
