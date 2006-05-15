<?php
require_once 'backend.php';
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
    mysql_query_from_file('db/mysql.sql', get_conn());
}
?>
