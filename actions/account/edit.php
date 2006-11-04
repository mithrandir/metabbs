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
render('account');

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
