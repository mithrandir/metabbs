<?php
function model($name) {
	global $model_dir;
	require_once "$model_dir/$name.php";
}

function get_table_name($model) {
	return 'meta_' . $model;
}
function get_column_pair($column) {
	return "$column->name=" . $column->to_string();
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
	function get_model_name() {
		if (!isset($this->model)) {
			$this->model = strtolower(get_class($this));
		}
		return $this->model;
	}
	function import($attributes) {
		if (is_array($attributes)) {
			foreach ($attributes as $key => $value) {
				$this->$key = $value;
			}
		}
	}
	function exists() {
		return $this->id;
	}
	function get_id() {
		return $this->id;
	}
	function create() {
		$db = get_conn();
		$model = $this->get_model_name();
		$table = get_table_name($model);
		$columns = $db->get_columns($table);
		$count = count($columns);
		for ($i = 0; $i < $count; $i++) {
			$column = &$columns[$i];
			$column->set_value(@$this->{$column->name});
		}
		$query = "INSERT INTO $table";
		$query .= " (".implode(",", array_map('get_column_name', $columns)).")";
		$query .= " VALUES(".implode(",", array_map('column_to_string', $columns)).")";
		$db->query($query);
		$this->id = $db->insertid();
	}
	function update() {
		$db = get_conn();
		$model = $this->get_model_name();
		$table = get_table_name($model);
		$columns = $db->get_columns($table);
		$count = count($columns);
		for ($i = 0; $i < $count; $i++) {
			$column = &$columns[$i];
			$column->set_value(@$this->{$column->name});
		}
		$query = "UPDATE $table SET ";
		$query .= implode(",", array_map('get_column_pair', $columns));
		$query .= " WHERE id=$this->id";
		$db->query($query);
	}
	function delete() {
		$db = get_conn();
		$db->query("DELETE FROM " . get_table_name($this->get_model_name()) . " WHERE id=$this->id");
	}
}
?>
