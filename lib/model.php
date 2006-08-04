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

class Association
{
	function Association($parent, $model) {
		$this->parent = $parent;
		$this->model = $model;
	}
}
class BelongsTo extends Association
{
	function find() {
		if (!isset($this->cache)) {
			$p = "{$this->model}_id";
			if ($this->parent->$p) {
				$this->cache = model_find($this->model, $this->parent->$p);
			} else {
				$this->cache = null;
			}
		}
		return $this->cache;
	}
}
class HasMany extends Association
{
	function get_condition() {
		return $this->parent->get_model_name().'_id='.$this->parent->id;
	}
	function find_all() {
		return model_find_all($this->model, $this->get_condition());
	}
	function count() {
		return model_count($this->model, $this->get_condition());
	}
	function clear() {
		return model_delete($this->model, $this->get_condition());
	}
}

class Model
{
	var $id;

	function Model($attributes = null) {
		$this->import($attributes);
		$this->_init();
	}
	function _init() { }
	function belongs_to($model) {
		return new BelongsTo($this, $model);
	}
	function has_many($model) {
		return new HasMany($this, $model);
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
