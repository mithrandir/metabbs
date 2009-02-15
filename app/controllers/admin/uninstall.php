<?php
if (is_post()) {
	check_form_token();

	$conn = get_conn();
	include('core/schema/uninstall.php');
	unlink('metabbs.conf.php');
	echo 'uninstallation finished.';
	exit;
}
?>
