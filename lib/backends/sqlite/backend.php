<?php
/*
SQLite backend by LuzLuna
*/

function get_conn() {
    static $conn;
    global $config;
    if (!isset($conn)) {
        $conn = new SQLiteAdapter;
        $conn->connect($config->get('dbfile'));
    }
    return $conn;
}

class SQLiteAdapter
{
    var $conn;

    function connect($dbfilename) {
        $this->conn = sqlite_open($dbfilename, 0666);
        register_shutdown_function(array(&$this, 'disconnect'));
    }
    function disconnect() {
        @sqlite_close($this->conn);
    }

    function query($query, $check_error = true) {
        if (!$query) {
            return;
        }
//echo $query;
        $result = @sqlite_query($query, $this->conn);
        if (!$result && $check_error) {
            trigger_error(sqlite_error_string(sqlite_last_error($this->conn)), E_USER_WARNING);
            exit;
        }
        return $result;
    }
    function querymany($queries) {
        foreach ($queries as $query) {
            $this->query($query);
        }
    }
    function query_from_file($name) {
        $data = trim(implode('', file($name)));
        $statements = explode(';', $data);
        array_walk($statements, array($this, 'query'));
    }
    function fetchall($query, $model = 'Model') {
        $results = array();
        $result = $this->query($query);
        while ($data = sqlite_fetch_array($result, SQLITE_ASSOC)) {
            $results[] = new $model($data);
        }
        return $results;
    }
    function fetchrow($query, $model = 'Model') {
        return new $model(sqlite_fetch_array($this->query($query), SQLITE_ASSOC));
    }
    function fetchone($query) {
        return sqlite_fetch_single($this->query($query));
    }
    function insertid() {
        return sqlite_last_insert_rowid($this->conn);
    }
    function add_table($table) {
        $this->querymany($table->to_sql());
    }
    function rename_table($ot, $t) {
        $this->query("ALTER TABLE meta_$ot RENAME TO meta_$t");
    }
    function drop_table($table) {
        $this->query("DROP TABLE meta_$table");
    }
}

function get_table_name($model) {
	return 'meta_' . $model;
}
function model_find($model, $id = null, $condition = '1') {
	$db = get_conn();
	if ($id) $condition = 'id='.$id.' AND '.$condition;
	$query = 'SELECT * FROM ';
	$query .= get_table_name($model);
	$query .= ' WHERE ' . $condition;
	return $db->fetchrow($query, $model);
}
function model_find_all($model, $condition = '1', $order = '', $offset = -1, $limit = -1) {
	$db = get_conn();
	$query = 'SELECT * FROM ';
	$query .= get_table_name($model);
	$query .= ' WHERE '.$condition;
	if ($order) $query .= ' ORDER BY '.$order;
	if ($offset > -1) $query .= ' LIMIT '.$offset.', '.$limit;
	return $db->fetchall($query, $model);
}
function model_count($model, $condition = '1') {
	$db = get_conn();
	$query = 'SELECT COUNT(*) FROM ';
	$query .= get_table_name($model);
	$query .= ' WHERE '.$condition;
	return $db->fetchone($query);
}
function model_delete($model, $condition = '1') {
	$db = get_conn();
	$query = 'DELETE FROM ';
	$query .= get_table_name($model);
	$query .= ' WHERE '.$condition;
	$db->query($query);
}
function model_insert($model, $data) {
	$db = get_conn();
	$query = 'INSERT INTO ';
	$query .= get_table_name($model);
	$query .= ' ('.implode(',', array_keys($data)).') VALUES(';
	foreach ($data as $key => $value) {
		$query .= '\''.addslashes($value).'\',';
	}
	$query = substr($query, 0, -1);
	$query .= ')';
	$db->query($query);
	return $db->insertid();
}
function model_update($model, $data, $condition = '1') {
	$db = get_conn();
	$query = 'UPDATE ';
	$query .= get_table_name($model);
	$query .= ' SET ';
	foreach ($data as $key => $value) {
		$query .= $key.'=\''.$value.'\',';
	}
	$query = substr($query, 0, -1);
	$query .= ' WHERE '.$condition;
	$db->query($query);
}
function model_datetime() {
	return date("YmdHis");
}

?>
