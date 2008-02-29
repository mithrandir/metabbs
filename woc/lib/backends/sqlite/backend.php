<?php
require_once dirname(__FILE__).'/../base.php';

class StringColumn {
	function to_spec() {
	}
}

class IntegerColumn {
	function to_spec() {
		return '';
	}
}

class BooleanColumn {
	function to_spec() {
		return '';
	}
}

class UshortColumn {
	function to_spec() {
		return '';
	}
}

class SQLiteConnection extends BaseConnection {
	var $conn;
	function open($info) {
		$this->conn = sqlite_open($info["dbname"], 0666, $error) or trigger_error($error, E_USER_ERROR);
	}
	function add_table() {

	}
	function query() {
	}
	function close($conn) {
		sqlite_close($conn);
	}
}
?>
