<?php
if (is_post()) {
	$conn = get_conn();
	include('db/uninstall.php');
	unlink('metabbs.conf.php');
	echo 'uninstallation finished.';
	exit;
}

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
