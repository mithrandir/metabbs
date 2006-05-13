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
        $conn = new MySQLAdapter;
        $conn->connect($config->get('host'), $config->get('user'), $config->get('password'));
        $conn->selectdb($config->get('dbname'));
        if ($config->get('force_utf8') == '1') {
            $conn->query('set names utf8');
        }
    }
    return $conn;
}

class MySQLAdapter
{
    var $conn;

    function connect($host, $user, $password) {
        $this->conn = mysql_connect($host, $user, $password);
        register_shutdown_function(array(&$this, 'disconnect'));
    }
    function disconnect() {
        @mysql_close($this->conn);
    }
    function selectdb($dbname) {
        mysql_select_db($dbname, $this->conn);
    }

    function query($query, $check_error = true) {
        if (!$query) {
            return;
        }
        $result = mysql_query($query, $this->conn);
        if (!$result && $check_error) {
            trigger_error(mysql_error($this->conn), E_USER_WARNING);
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
        while ($data = mysql_fetch_assoc($result)) {
            if (get_magic_quotes_runtime()) {
                $data = array_map('stripslashes', $data);
            }
            $results[] = new $model($data);
        }
        return $results;
    }
    function fetchrow($query, $model = 'Model') {
        $data = mysql_fetch_assoc($this->query($query));
        if (get_magic_quotes_runtime()) {
            stripslashes_deep($data);
        return new $model($data);
    }
    function fetchone($query) {
        $result = mysql_fetch_row($this->query($query));
        return (get_magic_quotes_runtime()) ? stripslashes($result[0]) : $result[0];
    }
    function insertid() {
        return mysql_insert_id($this->conn);
    }
    function add_table($t) {
        $this->query($t->to_sql());
    }
    function rename_table($ot, $t) {
        $this->query("RENAME TABLE meta_$ot TO meta_$t");
    }
    function drop_table($t) {
        $this->query("DROP TABLE meta_$t");
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
    if (!get_magic_quotes_gpc()) {
        $data = array_map('addslashes', $data);
    }
    $query = 'INSERT INTO ';
    $query .= get_table_name($model);
    $query .= ' ('.implode(',', array_keys($data)).') VALUES(';
    foreach ($data as $key => $value) {
        $query .= '\''.$value.'\',';
    }
    $query = substr($query, 0, -1);
    $query .= ')';
    $db->query($query);
    return $db->insertid();
}
function model_update($model, $data, $condition = '1') {
    $db = get_conn();
    if (!get_magic_quotes_gpc()) {
        $data = array_map('addslashes', $data);
    }
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
