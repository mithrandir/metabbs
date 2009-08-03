<?php
class Notice {
	var $messages = array();
	
	function exists() {
		return !empty($this->messages);
	}

	function add($msg, $key = null) {
		if (empty($msg)) return false;

		if(!$this->exists_by_key($key))
			$this->messages[$key] = array();

		array_push($this->messages[$key], $msg);
		return true;
	}

	function remove_by_key($key) {
		if (empty($key) || !$this->exists_by_key($key)) return false;
		
		$this->messages = array_diff_key($this->messages, array($key => null));
		return true;
	}

	function get_all() {
		return $this->exists() ? $this->messages : false;
	}
	function get_all_messages() {
		$messages = array();
		foreach( $this->messages as $k => $v)
			$messages = array_merge($messages, $v);
		return $messages;
	}

	function get_messages($key) {
		if(!$this->exists_by_key($key)) return array();

		return $this->messages[$key];
	}
	function get_first_message($key) {
		$messages = $this->get_messages($key);
		return empty($messages) ? null : $messages[0];
	}
	function exists_by_key($key) {
		return array_key_exists($key, $this->messages);
	}
}

class Flash {
	function set($msg) {
		$_SESSION['flash'] = $msg;
	}

	function get() {
		$msg = $_SESSION['flash'];
		unset($_SESSION['flash']);
		return $msg;
	}

	function exists() {
		return !empty($_SESSION['flash']);
	}
}

function error_message_box($message, $title='Error Messages') {
	ob_start();
	if (isset($message) && $message->exists()) {
		echo "<div id=\"error_messages\">\n";
		echo "<h2>".i($title)."</h2>\n";
		echo "<ul>\n";
		foreach ($message->get_all_messages() as $msg)
			echo "\t<li>".i($msg).".</li>\n";
		echo "</ul>\n";
		echo "</div>\n";
	}
	$ret = ob_get_contents();
	ob_end_clean();

	return $ret;
}
function marked_by_error_message($key, $message) {
	return $message->exists_by_key($key) ? 'field_error':'';
}
function flash_message_box() {
	ob_start();
	if (Flash::exists())
		echo "<p id=\"flash_message\">".i(Flash::get()).".</p>";
	$ret = ob_get_contents();
	ob_end_clean();

	return $ret;
}
?>