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
	$config->set('theme', $settings['theme']);
	$config->set('default_language', $settings['default_language']);
	$config->set('always_use_default_language', $settings['always_use_default_language']);
	import_default_language(); // reload language data
	$config->set('timezone', $settings['timezone']);
	Timezone::set($settings['timezone']);
	$config->set('force_fancy_url', $settings['force_fancy_url']);
	$config->write_to_file();
	$flash = i('Setting saved.');
	$flash_class = 'pass';
}

$default_language = $config->get('default_language', SOURCE_LANGUAGE);
$current_tz = Timezone::get();
$current_theme = get_current_theme();
$themes = get_themes();
?>
