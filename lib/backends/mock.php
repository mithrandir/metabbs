<?php
class MockDatabase {
	var $sequence = 1;
	var $data = array();

	function get_columns($table) {
		return $this->columns;
	}
	function quote_identifier($id) {
		return "`$id`";
	}
	function quote($value) {
		if (is_numeric($value)) return $value;
		else return "'".$this->escape($value)."'";
	}
	function escape($string) {
		return addslashes($string);
	}
	function query($query) {
		$this->query = $query;
		return new MockResult($this->data);
	}
	function execute($query) {
		$this->query = $query;
	}
	function insertid() {
		return $this->sequence++;
	}
}

class MockResult {
	function MockResult($data) {
		$this->data = $data;
	}
	function fetch() {
		return array_shift($this->data);
	}
}
?>
