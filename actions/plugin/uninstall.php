<?php
$plugin->delete();
if ($plugin->uninstall_function) {
	$func = $plugin->uninstall_function;
	$func();
}
redirect_to(url_for('admin', 'plugins'));
?>
