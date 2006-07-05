<?php
if (is_post()) {
	$old_password = $account->password;	
	$account->import($_POST['user']);
	$new_password = $account->password;
	if ($new_password) {
		cookie_register('password', md5($new_password));
		$account->password = md5($new_password);
	}
	else {
		$account->password = $old_password;
	}
	$account->update();
	redirect_back();
}
render('account/edit');
?>
