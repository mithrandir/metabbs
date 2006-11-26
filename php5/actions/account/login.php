<?php
if (is_post()) {
	$account = UserManager::login($_POST['user'], $_POST['password']);
	if (!$account) {
		$account = new Guest;
		$flash = 'Login failed.';
	} else {
		redirect_back();
	}
}
render('login');
?>
