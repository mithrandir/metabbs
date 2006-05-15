<?php
require_once 'backend.php';
function db_info_form() {
    field('host', 'Hostname', 'localhost');
    field('user', 'User ID', 'root');
    field('password', 'Password', '', 'password');
    field('dbname', 'DB name', '');
}
function is_supported() {
    return function_exists('pg_connect');
}
function init_db() {
    $conn = get_conn();
    $conn->query_from_file('db/pgsql.sql');
}
?>
