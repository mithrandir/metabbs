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
			"dbname" => $testdb
		));
	function testTo_spec() {
		var $name = "testname";
		$test_int = to_spec($name, "Integer", null); 
		$this->assertEqual($test_int, "`testname` integer(10) NOT NULL DEFAULT '0'");
		$test_str = to_spec($name, "String", 1);
		$this->assertEqual($name, "`testname` varchar(1) NOT NULL DEFAULT ''");
		$test_bool = to_spec($name, "Boolean", null);
		$this->assertEqual($name, "`testname` bool NOT NULL");
	}
}
?>
