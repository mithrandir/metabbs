<?php
if (is_post()) {
	$info = $_POST['user'];
	apply_filters('ValidateAccountSignup', $_POST, $error_messages);

	$user = new User($info);
	$user->validate_before_create($error_messages);

	if(!$error_messages->exists()) {
		$user->password = md5($user->password);	
		$user->create();
		redirect_to(url_with_referer_for('account', 'login'));
	} 
	unset($user);
	$account = new Guest($info);
	$account->password = "";
} else {
	$account->name = '';
}
?>
