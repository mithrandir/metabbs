<?php
require_once '../lib/backends/mysql/backend.php';

class MySQLTest extends UnitTestCase {
	function setUp() {
		$this->conn = new MySQLConnection;
	}
	function testOpen() {
		$username = "root";
		$password = "";
		$this->conn->open(array(
			"host" => "localhost",
			"user" => $username,
			"password" => $password,
			"dbname" => "metabbs_test"
		));
	}
}
?>
