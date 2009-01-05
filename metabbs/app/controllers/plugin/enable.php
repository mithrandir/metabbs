<?php
if (!$plugin->exists()) {
	$plugin->installed_version = $plugin->version;
	$plugin->enabled = 1;
	$plugin->create();
	$plugin->on_install();
} else {
	$plugin->enable();
}
redirect_to(url_for('admin', 'plugins'));
?>
