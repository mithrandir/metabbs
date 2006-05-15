<?php
require_once 'mysql.php';
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
    $conn->query_from_file('db/mysql.sql');
}
?>
