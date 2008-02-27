<?php
global $__db;

require_once "../lib/model.php";
require_once "../lib/query.php";
require_once "../lib/backends/sqlite/backend.php";
require_once "../lib/backends/sqlite/installer.php";

$testdb="metabbs_test";

$__db = new SQLiteConnection;
$__db->open(array(
		"dbname" => $testdb
		));
//$__db->enable_utf8();

if (!function_exists('rollback')) {
	function rollback() {
		global $__db;
		$__db->execute("ROLLBACK");
		$__db->execute("BEGIN");
	}
}

if (!file_exists('fixtures/.sqlite_schema')) {
	include "../db/schema.php";
	run($__db);
	touch('fixtures/.sqlite_schema');
}

include_once 'fixtures/sqlite_data.php';
if (!file_exists('fixtures/.sqlite_fixture') ||
	file_get_contents('fixtures/.sqlite_fixture') < filemtime('fixtures/sqlite_data.php')) {
	foreach ($fixtures as $model => $fixture) {
		require_once "../app/models/$model.php";
		$__db->execute("DELETE FROM $model");
		foreach ($fixture as $record) {
			$r = new $model($record);
			$r->create();
		}
	}
	$fp = fopen('fixtures/.sqlite_fixture', 'w');
	fwrite($fp, filemtime('fixtures/sqlite_data.php'));
	fclose($fp);
}

$__db->execute("BEGIN"); // start transaction
?>
