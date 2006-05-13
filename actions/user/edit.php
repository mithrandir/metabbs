<?php
if (is_post()) {
	$old_password = $user->password;	
	$user->import($_POST['user']);
	$new_password = $user->password;
	if ($new_password) {
		cookie_register('password', md5($new_password));
		$user->password = md5($new_password);
	}
	else {
		$user->password = $old_password;
	}
	$user->save();
	redirect_back();
}
?>
