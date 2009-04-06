<?php
if (isset($params['keyword'])) {
	require_once('core/backends/'.$config->get('backend').'/installer.php');
	import_plugin($params['keyword']);
	$plugin = $__plugins[$params['keyword']];
}
?>
