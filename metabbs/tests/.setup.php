<?php
global $__db;

require_once "../lib/model.php";
require_once "../lib/finder.php";
require_once "../lib/backends/mysql/backend.php";
require_once "../lib/backends/mysql/installer.php";

$__db = new MySQLConnection;
$__db->connect("localhost", "root", "");
$__db->selectdb("metabbs_test");
$__db->enable_utf8();

if (!file_exists('fixtures/.schema')) {
	include "../db/schema.php";
	run($__db);
	touch('fixtures/.schema');
}

include_once 'fixtures/data.php';
if (!file_exists('fixtures/.fixture') ||
	file_get_contents('fixtures/.fixture') < filemtime('fixtures/data.php')) {
	foreach ($fixtures as $model => $fixture) {
		require_once "../app/models/$model.php";
		$__db->execute("DELETE FROM $model");
		foreach ($fixture as $record) {
			$r = new $model($record);
			$r->create();
		}
	}
	$fp = fopen('fixtures/.fixture', 'w');
	fwrite($fp, filemtime('fixtures/data.php'));
	fclose($fp);
}

$__db->execute("BEGIN"); // start transaction
?>
