<?php
require_once 'backend.php';
function db_info_form() {
    field('dbfile', 'DB file', 'data/sqlite.db');
}
function is_supported() {
    return function_exists('sqlite_open');
}
function init_db() {
    $conn = get_conn();
    $conn->query_from_file('db/sqlite.sql');
}
?>
