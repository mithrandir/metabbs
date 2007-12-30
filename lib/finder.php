<?php
function find($model, $id) {
	return find_by($model, 'id', $id);
}

function find_and_cache($model, $id) {
	global $__cache;
	$key = $model.'_'.$id;
	if (!isset($__cache[$key])) {
		$o = call_user_func('find', $model, $id);
		$__cache[$key] = $o;
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

function find_all($model, $condition = '') {
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
?>
