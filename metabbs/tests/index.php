<?php
require 'simpletest/unit_tester.php';

$cases = array();
foreach (glob('*_test.php') as $case) {
	$cases[] = substr($case, 0, -9);
}

require_once "../lib/model.php";
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

include 'fixtures/data.php';
if (!file_exists('fixtures/.fixture') ||
	file_get_contents('fixtures/.fixture') < filemtime('fixtures/data.php')) {
	foreach ($fixtures as $model => $fixture) {
		require_once "../app/models/$model.php";
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

class ExtendedHtmlReporter extends HtmlReporter {
	function ExtendedHtmlReporter($cases) {
		$this->cases = $cases;
	}
	function paintHeader($test_name) {
		HtmlReporter::paintHeader($test_name);
		echo "<p>";
		echo "<a href=\"?test=all\">All</a>";
		foreach ($this->cases as $case) {
			echo " | <a href=\"?test=$case\">$case</a>";
		}
		echo "</p>";
	}
}

$test = &new TestSuite('MetaBBS Tests');
if (isset($_GET['test']) && in_array($_GET['test'], $cases)) {
	$test->addTestFile("$_GET[test]_test.php");
} else {
	foreach ($cases as $case) $test->addTestFile("${case}_test.php");
}
$test->run(new ExtendedHtmlReporter($cases));

function cleanup() {
	global $__db;
	$__db->execute("ROLLBACK");
	$__db->execute("BEGIN");
}

cleanup();
?>
