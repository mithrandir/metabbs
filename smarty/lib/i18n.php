<?php
function i() {
	global $lang;
	$args = func_get_args();
	return vsprintf($lang->get(array_shift($args)), $args);
}

class I18N extends Config {
	function I18N($lang) {
		$this->Config("lang/$lang.php");
		$this->lang = $lang;
	}
	function get($text) {
		if ($this->lang == 'en') {
			return $text;
		} else {
			return Config::get($text, $text);
		}
	}
}

$lang = new I18N('ko'); //XXX
?>
