<?php
define('METABBS_DB_REVISION', 702);

function get_table_name($model) {
	return METABBS_TABLE_PREFIX . $model;
}
function get_column_pair($key, $value) {
	return "$key=$value";
}

class Model
{
	var $id;

	function Model($attributes = null) {
		$this->db = get_conn();
		$this->import($attributes);
		$this->_init();
	}
	function _init() { }
	function import($attributes) {
		if (is_array($attributes)) {
			foreach ($attributes as $key => $value) {
				$this->$key = $value;
			}
		}
	}
	function exists() {
		return !!$this->id;
	}
	function get_id() {
		return $this->id;
	}
	function get_columns() {
		$columns = $this->db->get_columns($this->table);
		$data = array();
		foreach ($columns as $k) {
			$data[$k] = "'" . mysql_real_escape_string($this->$k) . "'";
		}
		return $data;
	}
	function create() {
		$columns = $this->get_columns();
		$query = "INSERT INTO $this->table";
		$query .= " (".implode(",", array_keys($columns)).")";
		$query .= " VALUES(".implode(",", array_values($columns)).")";
		$this->db->query($query);
		$this->id = $this->db->insertid();
	}
	function update() {
		$columns = $this->get_columns();
		$query = "UPDATE $this->table SET ";
		$query .= implode(",", array_map('get_column_pair', array_keys($columns), array_values($columns)));
		$query .= " WHERE id=$this->id";
		$this->db->query($query);
	}
	function delete() {
		$this->db->query("DELETE FROM $this->table WHERE id=$this->id");
	}
}
?>
