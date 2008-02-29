<?php 
class BaseConnection {
	function BaseConnection() {
		if(get_class($this) == 'BaseConnection')
			self::trigger_not_implemented_error();
	}
	function open($info) {	
		self::trigger_not_implemented_error();
	}
	function close() {
		self::trigger_not_implemented_error();
	}
	function execute($query) {
		self::trigger_not_implemented_error();
	}
	function query($query) { 
		self::trigger_not_implemented_error();
	}
	function last_insert_id($sequence_name) {
		self::trigger_not_implemented_error();
	}
	function bind_params($query, $params) {
		self::trigger_not_implemented_error();
	}
	function escape($string) {
		self::trigger_not_implemented_error();
	}
	function quote($value) {
		self::trigger_not_implemented_error();
	}
	function quote_identifier($id) {
		self::trigger_not_implemented_error();
	}
	function trigger_not_implemented_error() {
			list(, $callee) = debug_backtrace();
			$callee = $callee['class'].$callee['type'].$callee['function'].'()';
			trigger_error("Not implemented $callee", E_USER_ERROR);
	}
}

class BaseResultSet {
	function fetch() {
		BaseConection::trigger_not_implemented_error();
	}
	function fetch_column() {
		BaseConection::trigger_not_implemented_error();
	}
	function count() {
		BaseConection::trigger_not_implemented_error();
	}
}
