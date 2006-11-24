<?php
if (!$plugin->exists()) {
	$plugin->enabled = 1;
	$plugin->create();
	$plugin->on_install();
} else {
	$plugin->enable();
}
redirect_to(url_for('admin', 'plugins'));
?>
