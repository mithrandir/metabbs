<?php
if (!$account->is_admin()) {
	access_denied();
}
require_once('lib/backends/'.$config->get('backend').'/installer.php');
import_plugin($id);
$plugin = $__plugins[$id];
$view = 'admin';
?>
