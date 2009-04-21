<?php
global $config;

if (Plugin::is_enabled('OpenID') && !using_openid()) {
	$config->set('authentication', AUTH_DEFAULT | AUTH_OPENID);
	$config->write_to_file();
}
