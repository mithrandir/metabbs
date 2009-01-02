<?php
if (is_post()) {
	$settings = $_POST['settings'];
	$config->set('global_header', $settings['global_header']);
	$config->set('global_footer', $settings['global_footer']);
	$config->set('base_path', $settings['base_path']);
	$config->set('theme', $settings['theme']);
	$config->set('use_forget_password', $settings['use_forget_password']);
	$config->set('default_language', $settings['default_language']);
	$config->set('always_use_default_language', $settings['always_use_default_language']);
	import_default_language(); // reload language data
	$config->set('timezone', $settings['timezone']);
	Timezone::set($settings['timezone']);
	$config->set('force_fancy_url', $settings['force_fancy_url']);
	$config->set('captcha_name', $settings['captcha_name']);
	switch($settings['captcha_name']) {
		case "phpcaptcha":
			$config->set('flite_path', $settings['flite_path']);
			break;
		case "recaptcha":
			$config->set('captcha_privatekey', $settings['captcha_privatekey']);
			$config->set('captcha_publickey', $settings['captcha_publickey']);
			break;
		default:
			break;
	}
	$config->write_to_file();
	$flash = i('Setting saved.');
	$flash_class = 'pass';
}

$default_language = $config->get('default_language', SOURCE_LANGUAGE);
$current_tz = Timezone::get();
$current_theme = get_current_theme();
$themes = get_themes();
//$captcha = new Captcha($config->get('captcha_name', false), null);
?>
