<?php
if (!$account->is_admin()) {
	access_denied();
}
require_once('lib/backends/'.$config->get('backend').'/installer.php');
include_once('plugins/'.$id.'.php');
$plugin = $__plugins[$id];
$skin = '_admin';
?>
