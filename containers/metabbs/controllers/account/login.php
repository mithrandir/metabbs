<?php
if (is_post()) {
	$account = UserManager::login($params['user'], $params['password'], isset($params['autologin']));
	if (!$account) {
		$account = new Guest;
		$error_messages->add('Login failed');
	} else {
		redirect_back();
	}
}
?>
