<?php
if (is_post()) {
	$settings = $_POST['settings'];
    if ($settings['admin_password']) { 
        $new_password = md5($settings['admin_password']);
        if ($new_password != $account->password) {
            $user->password = $new_password;
            cookie_register('password', $account->password);
            $account->update();
        }
    }
	$config->set('global_header', $settings['global_header']);
	$config->set('global_footer', $settings['global_footer']);
	$config->write_to_file();
	$flash = 'Setting saved.';
	$flash_class = 'pass';
	render('settings');
}
?>
