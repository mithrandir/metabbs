<?php

function get_conn() {
    static $conn;
    global $db;
    if (!isset($conn)) {
        $conn = new MySQLAdapter;
        $conn->connect($db['host'], $db['user'], $db['password']);
        $conn->selectdb($db['dbname']);
    }
    return $conn;
}

class MySQLAdapter
{
    var $conn;

    function connect($host, $user, $password) {
        $this->conn = mysql_connect($host, $user, $password);
        $this->query('set names utf8');
        register_shutdown_function(array(&$this, 'disconnect'));
    }
    function disconnect() {
        @mysql_close($this->conn);
    }
    function selectdb($dbname) {
        mysql_select_db($dbname, $this->conn);
    }

    function query($query) {
        return mysql_query($query, $this->conn);
    }
    function fetchall($query) {
        $results = array();
        $result = $this->query($query);
        while ($data = mysql_fetch_assoc($result)) {
            $results[] = $data;
        }
        return $results;
    }
    function fetchrow($query) {
        return mysql_fetch_assoc($this->query($query));
    }
    function fetchone($query) {
        $result = mysql_fetch_row($this->query($query));
        return $result[0];
    }
    function insertid() {
        return mysql_insert_id($this->conn);
    }
}

class Model {
    var $id;

    function Model($attributes = array()) {
        $this->import($attributes);
        $this->db = get_conn();
        $this->init();
    }
    function init() {
    }
    function import($attributes) {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }
    function save() {
        if (!$this->id) {
            $this->create();
        } else {
            $this->update();
        }
    }
    function create() { }
    function update() { }
}

?>
