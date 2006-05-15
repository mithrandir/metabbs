<?php
/*
FIEL NAME : pgsql.php
Made By Overpace
Home : http://www.revocode9.com
E-mail :overpace@revocode9.com
*/

function get_conn() {
    static $conn;
    global $config;
    if (!isset($conn)) {
        $conn = new PgSQLAdapter;
        $conn->connect($config->get('host'), $config->get('user'),
				$config->get('password'), $config->get('dbname'));
    }
    return $conn;
}

class PgSQLAdapter
{
    var $conn;

    function connect($host, $user, $password, $dbname) {
		$this->conn=pg_connect("host=$host user=$user password=$password
		dbname=$dbname");
        register_shutdown_function(array(&$this, 'disconnect'));
    }
    function disconnect() {
        pg_close($this->conn);
    }

    function query($query, $check_error = true) {
        if (!$query) {
            return;
        }
        $result = pg_query($this->conn, $query);
        if (!$result && $check_error) {
            trigger_error(pg_result_error($result), E_USER_ERROR);
        }
        return $result;
    }
    function query_from_file($name) {
        $data = trim(implode('', file($name)));
        $statements = explode(';', $data);
        array_walk($statements, array($this, 'query'));
    }
    function fetchall($query, $model = 'Model') {
        $results = array();
        $result = $this->query($query);
		while ($data = pg_fetch_array($result, null, PGSQL_ASSOC)) {
          	$results[] = new $model($data);
		}
        return $results;
    }
    function fetchrow($query, $model = 'Model') {
        return new $model(pg_fetch_array($this->query($query), null, PGSQL_ASSOC));
    }
    function fetchone($query) {
        $result = pg_fetch_row($this->query($query));
        return $result[0];
    }
    function insertid($table) {
        return $this->fetchone('SELECT max(id) from '.$table); // XXX
    }
}

function get_table_name($model) {
	return 'meta_' . $model . 's';
}
function model_find($model, $id = NULL, $condition = '') {
	$db = get_conn();
	$query = 'SELECT * FROM ';
	$query .= get_table_name($model);
    if ($id) {
        $query .= "WHERE id=$id";
        if ($condition) {
            $query .= " AND $condition";
        }
    }
    else if ($condition) {
        $query .= "WHERE $condition";
    }
	return $db->fetchrow($query, $model);
}
function model_find_all($model, $condition = '' , $order = '', $offset = -1, $limit = -1) {
	$db = get_conn();
	$query = 'SELECT * FROM ';
	$query .= get_table_name($model);
	if ($condition) $query .= ' WHERE '.$condition;
	if ($order) $query .= ' ORDER BY '.$order;
	if ($offset > -1 && $limit > -1) $query .= ' OFFSET '.$offset.' LIMIT '.$limit;
	return $db->fetchall($query, $model);
}
function model_count($model, $condition = '') {
	$db = get_conn();
	$query = 'SELECT COUNT(*) FROM ';
	$query .= get_table_name($model);
	if ($condition) $query .= ' WHERE '.$condition;
	return $db->fetchone($query);
}
function model_delete($model, $condition) {
	$db = get_conn();
	$query = 'DELETE FROM ';
	$query .= get_table_name($model);
	if ($condition) $query .= ' WHERE '.$condition;
	$db->query($query);
}
function model_insert($model, $data) {
	$db = get_conn();
	$query = 'INSERT INTO ';
	$query .= ($table=get_table_name($model));
	$query .= ' ("'.implode('","', array_keys($data)).'") VALUES(';
	foreach ($data as $key => $value) {
		$query .= '\''.addslashes($value).'\',';
	}
	$query = substr($query, 0, -1);
	$query .= ')';
    $db->query($query);
	return $db->insertid($table);
}
function model_update($model, $data, $condition = '1') {
	$db = get_conn();
	$query = 'UPDATE ';
	$query .= get_table_name($model);
	$query .= ' SET ';
	foreach ($data as $key => $value) {
		$query .= '"'.$key.'"=\''.addslashes($value).'\',';
	}
	$query = substr($query, 0, -1);
	$query .= ' WHERE '.$condition;
	$db->query($query);
}

function model_datetime(){
	return date("Y-m-d H:i:s");
}

?>
