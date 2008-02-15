<?php
require_once dirname(__FILE__).'/backend.php';
class Table
{
	var $name;
	var $columns = array();

	function Table($name) {
		$this->name = $name;
		$this->table = get_table_name($name);
	}
	function _column($name, $type, $length = null) {
		//$class = $type.'Column';
		//$column = new $class($name);
		return $column->to_spec($name, $type, $length);
	}
	function column($name, $type, $length = null) {
		$this->columns[] = $this->_column($name, $type, $length);
	}
	function add_index($name) {
		$this->columns[] = "KEY `{$this->name}_${name}_index` (`$name`)";
	}
	function to_sql() {
		$db = get_conn();
		array_unshift($this->columns, "`id` int(10) unsigned NOT NULL auto_increment PRIMARY KEY");
		$sql = "CREATE TABLE `$this->table` (\n";
		$sql .= implode(",\n", $this->columns);
		$sql .= "\n)\n";
		return $sql;
	}
}
class SQLExporter {
	function SQLExporter() {
		$this->db = get_conn();
	}
	function to_sql($t) {
		$sql = array();
		$columns = $this->db->get_columns($t);
		array_unshift($columns, 'id');
		$_columns = array();
		foreach ($columns as $c) {
			$_columns[] = "`$c`";
		}
		$prefix = "INSERT INTO $t (".implode(",", $_columns).") VALUES(";
		$result = $this->db->query("SELECT * FROM $t");
		while ($data = $result->fetch()) {
			$values = array();
			foreach ($columns as $c) {
				$values[] = "'".$this->db->escape($data[$c])."'";
			}
			$sql[] = $prefix . implode(",", $values) . ");";
		}
		return implode("\n", $sql)."\n\n";
	}
}
function db_info_form() {
	field('host', 'Hostname', 'localhost', 'text', 'Host이름을 입력합니다. 대부분 localhost입니다.');
	field('user', 'User ID', 'root', 'text', 'Database 사용자의 아이디를 입력합니다.');
	field('password', 'Password', '', 'password', 'Database의 비밀번호를 입력합니다.');
	field('dbname', 'DB name', '', 'text', 'Database 이름을 입력합니다.');
}
function is_supported() {
	return function_exists('mysql_connect');
}
function init_db() {
	$conn = get_conn();
	list($major, $minor) = $conn->get_server_version();
	if (($major == 4 && $minor >= 1) || $major > 4) {
		global $config;
		$config->set('force_utf8', 1);
		$config->write_to_file();
		$conn->enable_utf8();
	}
	run($conn);
}
?>
