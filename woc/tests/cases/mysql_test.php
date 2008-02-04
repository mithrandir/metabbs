<?php
require_once '../lib/backends/mysql/backend.php';
require_once 'config.php';

class MySQLTest extends UnitTestCase {
	function setUp() {
		$this->conn = new MySQLConnection;
	}
	function testOpen() {
		//$username = "root";
		//$password = "";
		//$dbname="metabbs_test";
		$this->conn->open(array(
			"host" => "localhost",
			"user" => $username,
			"password" => $password,
			"dbname" => $dbname
		));
	}
}
?>
