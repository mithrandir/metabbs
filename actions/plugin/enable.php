<?php
if (!$plugin->exists()) {
	$plugin->enabled = 1;
	$plugin->create();
	if ($plugin->install_function) {
		$func = $plugin->install_function;
		$func();
	}
} else {
	$plugin->enable();
}
redirect_to(url_for('admin', 'plugins'));
?>
