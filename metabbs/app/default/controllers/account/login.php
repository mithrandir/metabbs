<?php
if (is_post()) {
	$account = UserManager::login($_POST['user'], $_POST['password'], isset($_POST['autologin']));
	apply_filters('BeforeLogin', $account, $_POST);
	if (!$account) {
		$account = new Guest;
		$error_messages->add('Login failed');
	} else {
		redirect_back();
	}
}
?>
