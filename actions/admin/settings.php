<?php
if (is_post()) {
	$settings = $_POST['settings'];
	$new_password = md5($settings['admin_password']);
	if ($new_password != $user->password) {
		$user->password = $new_password;
		cookie_register('password', $user->password);
		$user->update();
	}
	$config->set('global_header', $settings['global_header']);
	$config->set('global_footer', $settings['global_footer']);
	$config->write_to_file();
	$flash = 'Setting saved.';
	$flash_class = 'pass';
	render('settings');
}
?>
