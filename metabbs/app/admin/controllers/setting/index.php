<?php
if (is_post()) {
	check_form_token();
	$settings = $_POST['settings'];
	$config->set('global_header', $settings['global_header']);
	$config->set('global_footer', $settings['global_footer']);
	$config->set('base_path', $settings['base_path']);
	$config->set('theme', $settings['theme']);
	$config->set('use_forget_password', $settings['use_forget_password']);
	$config->set('default_language', $settings['default_language']);
	$config->set('always_use_default_language', $settings['always_use_default_language']);
	$config->set('use_openid', $settings['use_openid']);
	import_default_language(); // reload language data
	$config->set('timezone', $settings['timezone']);
	Timezone::set($settings['timezone']);
	$config->set('authentication', $settings['authentication']);	
	$config->set('force_fancy_url', $settings['force_fancy_url']);
	if ($settings['plugin_extra_path'] &&
			substr($settings['plugin_extra_path'], -1, 1) != '/')
		$settings['plugin_extra_path'] .= '/';
	$config->set('plugin_extra_path', $settings['plugin_extra_path']);
	$config->write_to_file();
	Flash::set('Setting saved');
	redirect_to(url_admin_for('setting'));	
}

$default_language = $config->get('default_language', SOURCE_LANGUAGE);
$authentication = $config->get('authentication', 1);
$current_tz = Timezone::get();
$current_theme = get_current_theme();
$themes = get_themes();
?>
