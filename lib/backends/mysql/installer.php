<?php
require_once 'backend.php';
class Table
{
    var $name;
    var $columns = array();
    var $types = array(
        'integer' => array('int', 10, 0),
        'string' => array('varchar', 255, ''),
        'text' => array('text', null, null),
        'timestamp' => array('timestamp', null, null)
    );

    function Table($name) {
        $this->name = $name;
    }
    function column($name, $type, $length = null) {
        $_type = $this->types[$type];
        if ($length) {
            $column = "`$name` $_type[0]($length) NOT NULL";
        } else {
            $column = "`$name` $_type[0]";
            if ($_type[1]) {
                $column .= "($_type[1])";
            }
            $column .= " NOT NULL";
        }
        if ($_type[2] !== null) {
            $column .= " default '$_type[2]'";
        }
        $this->columns[] = $column;
    }
    function add_index($name) {
        $this->columns[] = "KEY `{$this->name}_${name}_index` (`$name`)";
    }
    function to_sql() {
        array_unshift($this->columns, "`id` int(10) unsigned NOT NULL auto_increment PRIMARY KEY");
        $sql = "CREATE TABLE `meta_$this->name` (\n";
        $sql .= implode(",\n", $this->columns);
        $sql .= "\n)\n";
        return $sql;
    }
}
function db_info_form() {
    field('host', 'Hostname', 'localhost');
    field('user', 'User ID', 'root');
    field('password', 'Password', '', 'password');
    field('dbname', 'DB name', '');
}
function is_supported() {
    return function_exists('mysql_connect');
}
function init_db() {
    $conn = get_conn();
    //$conn->query_from_file('db/mysql.sql', get_conn());
    include("db/schema.php");
}
?>
