<?php
require_once 'backend.php';
class Table
{
	var $name;
	var $columns = array();
	var $types = array(
		'integer' => array('int', 10, 0),
		'string' => array('varchar', 255, ''),
		'text' => array('text', null, null),
		'timestamp' => array('timestamp', null, null)
	);

	function Table($name) {
		$this->name = $name;
	}
	function _column($name, $type, $length = null) {
		$_type = $this->types[$type];
		if ($_type == 'integer' && $length == 1) {
			$_type = 'tinyint';
		}
		if ($length) {
			$column = "`$name` $_type[0]($length) NOT NULL";
		} else {
			$column = "`$name` $_type[0]";
			if ($_type[1]) {
				$column .= "($_type[1])";
			}
			$column .= " NOT NULL";
		}
		if ($_type[2] !== null) {
			$column .= " default '$_type[2]'";
		}
		return $column;
	}
	function column($name, $type, $length = null) {
		$this->columns[] = $this->_column($name, $type, $length);
	}
	function add_index($name) {
		$this->columns[] = "KEY `{$this->name}_${name}_index` (`$name`)";
	}
	function to_sql() {
		array_unshift($this->columns, "`id` int(10) unsigned NOT NULL auto_increment PRIMARY KEY");
		$sql = "CREATE TABLE `".get_table_name($this->name)."` (\n";
		$sql .= implode(",\n", $this->columns);
		$sql .= "\n)\n";
		return $sql;
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
	//$conn->query_from_file('db/mysql.sql', get_conn());
	include("db/schema.php");
}
?>
