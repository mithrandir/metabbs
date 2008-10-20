<?php
require 'lib/page.php';
$page = get_requested_page();
if (isset($_GET['key']) && isset($_GET['query'])) {
	$users = User::search($_GET['key'], $_GET['query']);
	$users_count = count($users);
} else {
	$users_count = User::count();
	$users = User::find_all(10, ($page - 1) * 10);
}
?>
