<?php
define('METABBS_DIR', '.');
require_once "lib/core.php";
require_once "lib/backends/$backend/installer.php";
include 'db/schema.php';

$conn = get_conn();
if (isset($_GET['rev'])) {
	$current = $_GET['rev'];
} else {
	$current = $config->get('revision', 347);
}

if ($current < METABBS_DB_REVISION) {
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
	$config->set('revision', METABBS_DB_REVISION);
	$config->write_to_file();
	echo 'done.';
} else {
	echo 'schema is up to date';
}
?>
