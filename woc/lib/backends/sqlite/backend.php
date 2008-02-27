<?php
require_once dirname(__FILE__).'/../base.php';

//Test 통과를 위한 dummy code
class stringColumn {
	function to_spec() {
	}
}
//dummy code 끝

class SQLiteConnection extends BaseConnection {
	var $conn;
	function open($info) {
		$this->conn = sqlite_open($info["dbname"], 0666, $error) or trigger_error($error, E_USER_ERROR);
	}
	function close($conn) {
		sqlite_close($conn);
	}
}
?>
