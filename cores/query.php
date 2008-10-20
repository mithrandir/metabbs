<?php
class ObjectCache {
	var $map = array();

	function has($key) {
		return array_key_exists($key, $this->map);
	}

	function get($key) {
		return $this->map[$key];
	}

	function put($key, $object) {
		$this->map[$key] = $object;
	}

	function reset() {
		$this->map = array();
	}
}

$__cache = new ObjectCache;

function find($model, $id) {
	global $__cache;
	$key = $model . '#' . $id;
	if (!$__cache->has($key)) {
		$object = find_by($model, 'id', $id);
		$__cache->put($key, $object);
		return $object;
	} else return $__cache->get($key);
}

// deprecated; use find
function find_and_cache($model, $id) {
	return find($model, $id);
}

function find_by($model, $key, $value) {
	global $__db;
	return find_first($model, $__db->quote_identifier($key)."=".$__db->quote($value));
}

function find_first($model, $condition = '') {
	global $__db;
	$table = get_table_name($model);
	$query = "SELECT * FROM $table";
	if ($condition) $query .= " WHERE $condition";
	$result = $__db->query($query);
	return new $model($result->fetch());
}

function find_all($model, $condition = '', $order = '', $limit = 0, $offset = NULL) {
	global $__db;
	$table = get_table_name($model);
	$list = array();
	$query = "SELECT * FROM $table";
	if ($condition) $query .= " WHERE $condition";
	if ($order) $query .= " ORDER BY $order";
	if ($limit) {
		if ($offset) $query .= " LIMIT $offset, $limit";
		else $query .= " LIMIT $limit";
	}
	$result = $__db->query($query);
	while ($row = $result->fetch()) {
		$list[] = new $model($row);
	}
	return $list;
}

function count_all($model, $condition = '') {
	global $__db;
	$table = get_table_name($model);
	$query = "SELECT COUNT(*) FROM $table";
	if ($condition) $query .= " WHERE $condition";
	$result = $__db->query($query);
	return $result->fetch_column();
}

function delete_all($model, $condition = '') {
	global $__db;
	$table = get_table_name($model);
	$query = "DELETE FROM $table";
	if ($condition) $query .= " WHERE $condition";
	$__db->execute($query);
}

function insert($model, $data) {
	global $__db;
	$table = get_table_name($model);
	$keys = array_map(array(&$__db, 'quote_identifier'), array_keys($data));
	$values = array_map(array(&$__db, 'quote'), array_values($data));
	
	$query = "INSERT INTO $table";
	$query .= " (".implode(", ", $keys).")";
	$query .= " VALUES(".implode(", ", $values).")";
	$__db->execute($query);
	return $__db->insertid();
}

function update_all($model, $data, $condition = '') {
	global $__db;
	$table = get_table_name($model);
	$query = "UPDATE $table SET ";
	$parts = array();
	foreach ($data as $k => $v) {
		$parts[] = $__db->quote_identifier($k)."=".$__db->quote($v);
	}
	$query .= implode(", ", $parts);
	if ($condition) $query .= " WHERE $condition";
	$__db->execute($query);
}
?>
