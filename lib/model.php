<?php
function model($name) {
	global $model_dir;
	require_once "$model_dir/$name.php";
}

function get_table_name($model) {
	return 'meta_' . $model;
}
function model_find($model, $id = null, $condition = null) {
	$db = get_conn();
	if ($id) $condition = "id=$id";
	$query = "SELECT * FROM " . get_table_name($model);
	if ($condition)	$query .= " WHERE $condition";
	return $db->fetchrow($query, $model);
}
function model_find_all($model, $condition = null, $order = null, $offset = null, $limit = null) {
	$db = get_conn();
	$query = "SELECT * FROM " . get_table_name($model);
	if ($condition) $query .= " WHERE $condition";
	if ($order) $query .= " ORDER BY $order";
	if ($offset && $limit)
		$query .= "LIMIT $limit OFFSET $offset";
	return $db->fetchall($query, $model);
}
function model_count($model, $condition = null) {
	$db = get_conn();
	$query = "SELECT COUNT(*) FROM " . get_table_name($model);
	if ($condition) $query .= " WHERE $condition";
	return $db->fetchone($query);
}
function model_delete($model, $condition = null) {
	$db = get_conn();
	$query = "DELETE FROM " . get_table_name($model);
	if ($condition) $query .= " WHERE $condition";
	$db->query($query);
}

class Model
{
	var $id;

	function Model($attributes = null) {
		$this->import($attributes);
	}
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
		foreach ($columns as $column) {
			$column->set_value(@$this->{$column->name});
		}
		$query = "INSERT INTO $table";
		$query .= " (".implode(",", array_map('get_column_name', $columns)).")";
		$query .= " VALUES(".implode(",", array_map('column_to_string', $columns)).")";
		$db->query($query);
		$this->id = $db->insertid();
	}
	function delete() {
		model_delete($this->get_model_name(), 'id='.$this->id);
	}
}
?>
