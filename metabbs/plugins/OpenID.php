<?php
global $config;

class OpenID extends Plugin { } // dummy

$openid_plugin = Plugin::find_by_name('OpenID');
if ($openid_plugin->enabled) {
	$openid_plugin->disable();
	$config->set('use_openid', true);
	$config->write_to_file();
}
