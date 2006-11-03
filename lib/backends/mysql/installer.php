<?php
require_once 'backend.php';
class Table
{
	var $name;
	var $columns = array();

	function Table($name) {
		$this->name = $name;
		$this->table = get_table_name($name);
	}
	function _column($name, $type, $length = null) {
		$class = $type.'Column';
		$column = new $class($name);
		return $column->to_spec($length);
	}
	function column($name, $type, $length = null) {
		$this->columns[] = $this->_column($name, $type, $length);
	}
	function add_index($name) {
		$this->columns[] = "KEY `{$this->name}_${name}_index` (`$name`)";
	}
	function to_sql() {
		array_unshift($this->columns, "`id` int(10) unsigned NOT NULL auto_increment PRIMARY KEY");
		$sql = "CREATE TABLE `$this->table` (\n";
		$sql .= implode(",\n", $this->columns);
		$sql .= "\n)\n";
		if (defined('MYSQL_USE_UTF8') && MYSQL_USE_UTF8) {
			$sql .= 'CHARACTER SET utf8 COLLATE utf8_general_ci';
		}
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
	list($major, $minor) = $conn->get_server_version();
	if (($major == 4 && $minor >= 1) || $major > 4) {
		global $config;
		define('MYSQL_USE_UTF8', 1);
		$config->set('force_utf8', 1);
		$config->write_to_file();
		$conn->enable_utf8();
	}
	include("db/schema.php");
}

/* -*- mode: php; tab-width: 4; c-basic-offset: 4; indent-tabs-mode: t -*- */
/* vim: set ts=4 sts=4 sw=4 noet: */
?>
