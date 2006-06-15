<?php
if (is_post()) {
	$new_password = md5($_POST['settings']['admin_password']);
	if ($new_password != $user->password) {
		$user->password = $new_password;
		cookie_register('password', $user->password);
		$user->update();
	}
	$config->set('global_layout', $_POST['settings']['global_layout']);
	$config->write_to_file();
	$flash = 'Setting saved.';
	$flash_class = 'pass';
	render('settings');
}
?>
