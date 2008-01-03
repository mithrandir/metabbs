<?php
$__cache = array();

function find($model, $id) {
	return find_by($model, 'id', $id);
}

function find_and_cache($model, $id) {
	global $__cache;
	$key = $model.'_'.$id;
	if (!isset($__cache[$key])) {
		$__cache[$key] = find($model, $id);
	} else {
		$o = $__cache[$key];
	}
	return $o;
}

function find_by($model, $key, $value) {
	global $__db;
	$table = get_table_name($model);
	$result = $__db->query("SELECT * FROM $table WHERE ".$__db->quote_identifier($key)."=".$__db->quote($value));
	return new $model($result->fetch());
}

function find_all($model, $condition = '', $order = '', $offset = 0, $limit = NULL) {
	global $__db;
	$table = get_table_name($model);
	$list = array();
	$query = "SELECT * FROM $table";
	if ($condition) $query .= " WHERE $condition";
	$result = $__db->query($query);
	while ($row = $result->fetch()) {
		$list[] = new $model($row);
	}
	return $list;
}

function count_all($model, $condition = '') {
}

function delete_all($model, $condition = '') {
}

function insert($model, $data) {
}

function update_all($model, $data, $condition = '') {
}
?>
