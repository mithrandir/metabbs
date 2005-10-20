<?php

// $Header: /cvsroot/rubybbs/rubybbs/libs/MySQL.php,v 1.6 2005/01/22 00:14:57 ditto Exp $

function _get_conn() {
	global $conn, $db_host, $db_user, $db_passwd, $db_name;
	if (!isset($conn)) {
		$conn = new MySQL;
		$conn->connect($db_host, $db_user, $db_passwd);
		$conn->select_db($db_name);
		register_shutdown_function(array($conn, 'disconnect'));
	}
	return $conn;
}

class MySQL {
	var $conn;
	function connect($host, $id, $pass, $pconn = false) {
		if ($pconn) $this->conn = mysql_pconnect($host, $id, $pass);
		else $this->conn = mysql_connect($host, $id, $pass);
	}
	function select_db($db) {
		mysql_select_db($db, $this->conn);
	}
	function query($query) {
		$result = new MySQLresult($query, $this->conn);
		return $result;
	}
	function getOne($query) {
		$r = mysql_fetch_row(mysql_query($query, $this->conn));
		return $r[0];
	}
	function getRow($query) {
		return mysql_fetch_assoc(mysql_query($query, $this->conn));
	}
	function getInsertId() {
		return mysql_insert_id($this->conn);
	}
	function disconnect() {
		mysql_close($this->conn);
	}
}
class MySQLresult {
	var $result;
	function MySQLresult($query, $conn) {
		$this->result = mysql_query($query, $conn);
	}
	function fetchRow() {
		return mysql_fetch_assoc($this->result);
	}
	function numRows() {
		return mysql_num_rows($this->result);
	}
}
?>
