<?php
define('METABBS_DIR', '.');
require_once("lib/core.php");
require_once("lib/backends/$backend/installer.php");
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

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
