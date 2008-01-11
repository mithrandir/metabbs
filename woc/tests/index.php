<?php
require 'simpletest/unit_tester.php';

$cases = array();
foreach (glob('*_test.php') as $case) {
	$cases[] = substr($case, 0, -9);
}

function print_case_list($cases) {
	echo "<p>";
	echo "<a href=\"?test=all\">All</a>";
	foreach ($cases as $case) {
		echo " | <a href=\"?test=$case\">$case</a>";
	}
	if (file_exists('coverage'))
		echo " || <a href=\"coverage/\">Coverage Report</a>";
	echo "</p>";
}

class ExtendedHtmlReporter extends HtmlReporter {
	function ExtendedHtmlReporter($cases) {
		$this->cases = $cases;
	}
	function paintHeader($test_name) {
		HtmlReporter::paintHeader($test_name);
		print_case_list($this->cases);
	}
}

if (!isset($_GET['test'])) {
	echo "<h1>MetaBBS Tests</h1>";
	echo "<h2>Select the test case</h2>";
	print_case_list($cases);
} else {
	include '.setup.php';

	$test = &new TestSuite('MetaBBS Tests');
	if (in_array($_GET['test'], $cases)) {
		$test->addTestFile("$_GET[test]_test.php");
	} else {
		foreach ($cases as $case) $test->addTestFile("${case}_test.php");
	}
	$test->run(new ExtendedHtmlReporter($cases));

	include '.teardown.php';
}
?>
