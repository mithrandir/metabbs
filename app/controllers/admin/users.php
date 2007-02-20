<?php
require 'lib/page.php';
$page = get_requested_page();
$users_count = User::count();
$users = User::find_all(($page - 1) * 10, 10);
?>
