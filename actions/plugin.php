<?php
if (!$account->is_admin()) {
	access_denied();
}
include_once('plugins/'.$id.'.php');
$plugin = $__plugins[$id];
$skin = '_admin';
?>
