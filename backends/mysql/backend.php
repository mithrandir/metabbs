<?php
/*
MySQL backend by:
Kim Taeho aka ditto <dittos@gmail.com>
http://ditto.exca.net/
*/

function get_conn() {
    static $conn;
    global $config;
    if (!isset($conn)) {
        $conn = mysql_connect($config->get('host'), $config->get('user'), $config->get('password'));
        mysql_select_db($config->get('dbname'), $conn);
        if ($config->get('force_utf8') == '1') {
            mysql_query('set names utf8', $conn);
        }
    }
    return $conn;
}

function mysql_query_from_file($name, $conn) {
    $fp = fopen($name, 'r');
    if (!$fp) {
        return;
    }
    $buf = "";
    while (!feof($fp)) {
        $c = fgetc($fp);
        if ($c == ';') {
            mysql_query($buf, $conn);
            $buf = "";
        } else {
            $buf .= $c;
        }
    }
}

function get_table_name($model) {
	return "meta_${model}s";
}
function model_find($model, $id = null, $condition = '1') {
	if ($id) $condition = "id=$id AND $condition";
	$query = 'SELECT * FROM ' . get_table_name($model) . " WHERE $condition";
	return new $model(mysql_fetch_assoc(mysql_query($query, get_conn())));
}
function model_find_all($model, $condition = '1', $order = '', $offset = -1, $limit = -1) {
    $query = 'SELECT * FROM '.get_table_name($model)." WHERE $condition";
	if ($order) $query .= " ORDER BY $order";
	if ($offset > -1) $query .= " LIMIT $offset,$limit";
 
    $results = array();
    $result = mysql_query($query, get_conn());
    while ($data = mysql_fetch_assoc($result)) {
        $results[] = new $model($data);
    }
	return $results;
}
function model_count($model, $condition = '1') {
    $result = mysql_fetch_row(mysql_query('SELECT COUNT(*) FROM '.get_table_name($model)." WHERE $condition", get_conn()));
	return $result[0];
}
function model_delete($model, $condition = '1') {
	mysql_query('DELETE FROM '.get_table_name($model)." WHERE $condition", get_conn());
}
function model_insert($model, $data) {
	$db = get_conn();
	$query = 'INSERT INTO '.get_table_name($model);
	$query .= ' ('.implode(',', array_keys($data)).') VALUES(';
	foreach ($data as $key => $value) {
		$query .= '\''.addslashes($value).'\',';
	}
	$query = substr($query, 0, -1);
	$query .= ')';
	mysql_query($query, $db);
	return mysql_insert_id($db);
}
function model_update($model, $data, $condition = '1') {
	$query = 'UPDATE '.get_table_name($model).' SET ';
	foreach ($data as $key => $value) {
		$query .= $key.'=\''.addslashes($value).'\',';
	}
	$query = substr($query, 0, -1);
	$query .= ' WHERE '.$condition;
	mysql_query($query, get_conn());
}
function model_datetime() {
	return date("YmdHis");
}
?>
