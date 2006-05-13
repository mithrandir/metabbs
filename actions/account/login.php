<?php
if (is_post()) {
	$user = User::auth($_POST['user'], md5($_POST['password']));
	if ($user->exists()) {
		cookie_register("user", $user->user);
		cookie_register("password", $user->password);
		redirect_back();
	} else {
		$user = new Guest;
		$flash = 'Login failed.';
	}
}
?>
