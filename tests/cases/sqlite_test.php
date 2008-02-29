<?php
require_once '../lib/backends/sqlite/backend.php';
class SQLiteTest extends UnitTestCase {
	function setUp() {
		$testdb = ':memory:';
		$this->conn = new SQLiteConnection;
	}
	function testOpen() {
		$testdb = ':memory:';
		$this->conn->open(array(
			"dbname" => $testdb
			));
	}
	function testClose() {
		$testdb = ':memory:';
		$db_handle = $this->conn->open(array(
					"dbname" => $testdb
					)); //why null?
		var_dump($db_handle);
		$this->conn->close($db_handle);
	}
}
