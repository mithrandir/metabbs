<?php
if (is_post()) {
	$controller = 'account';
	$action = 'login';
	include 'app/controllers/account/login.php';
} else {
	$template = get_template($board, 'login');
	$template->set('board', $board);
}
?>
