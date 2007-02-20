<?php
$plugin->delete();
$plugin->on_uninstall();
redirect_to(url_for('admin', 'plugins'));
?>
