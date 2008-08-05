<?php
if (isset($_GET['format']) && $_GET['format'] == 'sql') {
	if (!file_exists('data/backup')) {
		mkdir('data/backup');
		chmod('data/backup', 0707);
	}

	@set_time_limit(0);
	require 'lib/backends/'.$config->get('backend').'/installer.php';
	$db = get_conn();
	$exporter = new SQLExporter;
	$filename = "metabbs_backup_" . date('Ymd') . ".sql";
	$fp = fopen('data/backup/' . $filename, 'w');
	foreach ($db->get_created_tables() as $t) {
		$exporter->to_sql($t, $fp);
	}
	fclose($fp);

	$backup_url = METABBS_BASE_PATH . 'data/backup/' . $filename;
}
?>
