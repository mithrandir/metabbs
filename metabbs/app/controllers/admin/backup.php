<?php
if (isset($_GET['format']) && $_GET['format'] == 'sql') {
	@set_time_limit(0);
	require 'lib/backends/'.$config->get('backend').'/installer.php';
	$db = get_conn();
	$exporter = new SQLExporter;
	$data = '';
	foreach ($db->get_created_tables() as $t) {
		$data .= $exporter->to_sql($t);
	}
	header('Content-Type: application/octet-stream');
	header('Content-Length: ' . strlen($data));
	header('Content-Disposition: attachment; filename="metabbs_backup_'.date('Ymd').'.sql"');
	header('Content-Transfer-Encoding: binary');
	echo $data;
	exit;
}
?>
