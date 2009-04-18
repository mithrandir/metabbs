<?php
if (isset($params['id'])) {
	require_once('core/backends/'.$config->get('backend').'/installer.php');
	import_plugin($params['id']);
	$plugin = $__plugins[$params['id']];
}
?>
