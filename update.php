<?php
define('METABBS_DIR', '.');
require_once("lib/core.php");
require_once("lib/backends/$backend/installer.php");
$conn = get_conn();
include('db/revision.php');
if (isset($_GET['rev'])) {
	$current = $_GET['rev'];
} else {
	$current = $config->get('revision', 347);
}

if ($current < $revision) {
	// find updates
	$dh = opendir('db');
	while ($f = readdir($dh)) {
		if (preg_match('/^update_([0-9]+)\.php$/', $f, $matches)) {
			if ($matches[1] > $current) {
				echo "applying patch r$matches[1]...<br />";
				include("db/$f");
			}
		}
	}
	closedir($dh);
	$config->set('revision', $revision);
	$config->write_to_file();
	echo 'done.';
} else {
	echo 'schema is up to date';
}
?>
