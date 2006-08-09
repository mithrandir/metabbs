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
        $data = mysql_fetch_assoc($this->query($query));
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

function model_datetime(){
    return date("Y-m-d H:i:s");
}

?>
