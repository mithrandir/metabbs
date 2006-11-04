<?php
if (is_post()) {
	$conn = get_conn();
	include('db/uninstall.php');
	unlink('metabbs.conf.php');
	echo 'uninstallation finished.';
	exit;
}
?>
