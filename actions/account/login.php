<?php
if (is_post()) {
	$user = UserManager::login($_POST['user'], $_POST['password']);
	if (!$user) {
		$user = new Guest;
		$flash = 'Login failed.';
	} else {
		redirect_back();
	}
}
?>
