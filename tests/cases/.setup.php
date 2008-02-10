<?php
global $__db;

require_once "../lib/model.php";
require_once "../lib/query.php";
require_once "../lib/backends/mysql/backend.php";
require_once "../lib/backends/mysql/installer.php";
require_once "config.php";

//$username = "root";
//$password = "";
//$testdb="metabbs_test";

$__db = new MySQLConnection;
$__db->connect("localhost", $username, $password);
$__db->selectdb($testdb);
$__db->enable_utf8();

if (!function_exists('rollback')) {
	function rollback() {
		global $__db;
		$__db->execute("ROLLBACK");
		$__db->execute("BEGIN");
	}
}

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
