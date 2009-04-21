<?php
global $config;

$openid_plugin = find_by('plugin', 'name', 'OpenID');
if ($openid_plugin->enabled && !using_openid()) {
	$config->set('authentication', AUTH_DEFAULT | AUTH_OPENID);
	$config->write_to_file();
	$openid_plugin->disable();
}
