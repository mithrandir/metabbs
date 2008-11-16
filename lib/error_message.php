<?php
class ErrorMessage {

	function ErrorMessage () {
		$this->errors = array();
	}

	function add($message, $error_field = null) {
		if (!empty($message))
			$this->errors[$error_field] = $message;
	}

	function exists() {
		return !empty($this->errors);
	}

	function get_all() {
		return $this->exists() ? $this->errors : false;
	}
	
	function get_error_messages($error_field) {
		$errors = array();
		foreach ($this->errors as $key => $value) {
			if ($key == $error_field) {
				array_push($errors, $value);
			}
		}
		return empty($errors) ? null : $errors;
	}
	function exists_by_field($error_field) {
		return array_key_exists($error_field, $this->errors);
	}
	function get_first_error_message($error_field) {
		$errors = $this->get_error_messages($error_field);
		return empty($errors[0]) ? null : $errors[0];
	}
}

?>