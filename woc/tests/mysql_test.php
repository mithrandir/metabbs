<?php
require_once ('../lib/backends/mysql/backend.php');

class MySQLTest extends UnitTestCase {
	function setUp() {
		$this->conn= new MySQLConnection;
	}
	function testOpen() {
		$username="root";
		$password="";
		$this->assertEqual($this->conn->open(array("host"=>"localhost","user"=>$username,"password"=>$password)),$this->conn->connect("localhost",$username, $password));
	}
}
?>
