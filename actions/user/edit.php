<?php
if (is_post()) {
	$new_password = $_POST['user']['password'];
	if (!$new_password) {
		unset($_POST['user']['password']);
	} else {
		cookie_register('password', md5($new_password));
	}
	$user->import($_POST['user']);
	$user->password = md5($user->password);
	$user->save();
	redirect_back();
}
?>
