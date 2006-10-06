<?php
if (!$plugin->exists()) {
	$plugin->name = $id;
	$plugin->enabled = 1;
	$plugin->create();
} else {
	$plugin->enable();
}
redirect_to(url_for('admin', 'plugins'));
?>
