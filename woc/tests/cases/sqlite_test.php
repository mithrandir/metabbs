<?php
require_once '../lib/backends/sqlite/backend.php';
class SQLiteTest extends UnitTestCase {
	function setUp() {
		$this->conn = new SQLiteConnection;
	}
	function testOpen() {
		$testdb = "metabbs_test";
		$this->conn->open(array(
			"dbname" => $testdb
			));
	}
}
