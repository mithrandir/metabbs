<?php
if (is_post()) {
	$account = UserManager::login($_POST['user'], $_POST['password'], isset($_POST['autologin']));
	if (!$account) {
		$account = new Guest;
		$flash = 'Login failed.';
	} else {
		redirect_back();
	}
}
?>
