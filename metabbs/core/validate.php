<?php
class Validate {
	function domain($value) {
		return ((strlen($value) <= 255) && preg_match('/^([[:alnum:]]+(-[[:alnum:]]+)*\\.)+[[:alnum:]]+(-[[:alnum:]]+)*$/', $value));
	}

	function email($value) {
		if (strlen($value) > 255)
			return false;
		$parts = explode('@', $value, 2);
		return ((count($parts) == 2) && preg_match('@[\\w!#\-\'*+/=?^`{-~-]+(\\.[\\w!#-\'*+/=?^`{-~-]+)*@', $parts[0]) && Validate::domain($parts[1]));
	}
	
	function identifier($value) {
		if (strlen($value) > 45)
			return false;
		return preg_match('/^[a-zA-Z0-9_-]+$/', $value);
	}
	
	function url($value) {
		$domain = str_replace('http://', '', str_replace('https://', '', $value));
		return Validate::domain($domain); 
	}
}
?>
