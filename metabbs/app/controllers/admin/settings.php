<?php
if (is_post()) {
	$settings = $_POST['settings'];
    if ($settings['admin_password']) { 
        $new_password = md5($settings['admin_password']);
        if ($new_password != $account->password) {
            $account->password = $new_password;
            $account->update();
        }
    }
	$config->set('global_header', $settings['global_header']);
	$config->set('global_footer', $settings['global_footer']);
	$config->set('default_language', $settings['default_language']);
	$config->set('always_use_default_language', $settings['always_use_default_language']);
	if ($settings['always_use_default_language']) {
		$lang = I18N::import($default_language = $settings['default_language']);
	}
	$config->set('timezone', $settings['timezone']);
	Timezone::set($settings['timezone']);
	$config->set('force_fancy_url', $settings['force_fancy_url']);
	$config->write_to_file();
	$flash = i('Setting saved.');
	$flash_class = 'pass';
}

$current_tz = Timezone::get();
?>
