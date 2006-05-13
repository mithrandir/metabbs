<?php
require_once 'backend.php';
function db_info_form() {
	field('host', 'Hostname', 'localhost', 'text', 'Host이름을 입력합니다. 대부분 localhost입니다.');
	field('user', 'User ID', 'root', 'text', 'Database 사용자의 아이디를 입력합니다.');
	field('password', 'Password', '', 'password', 'Database의 비밀번호를 입력합니다.');
	field('dbname', 'DB name', '', 'text', 'Database 이름을 입력합니다.');
}
function is_supported() {
	return function_exists('pg_connect');
}
function init_db() {
	$conn = get_conn();
	$conn->query_from_file('db/pgsql.sql');
}
?>
