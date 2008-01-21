<?php
require 'simpletest/unit_tester.php';

$cases = array();
$d = opendir('cases');
while ($f = readdir($d)) {
	if (preg_match('/^(.+?)_test.php$/', $f, $matches))
		$cases[] = $matches[1];
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
	include 'cases/.setup.php';

	$test = &new TestSuite('MetaBBS Tests');
	if (in_array($_GET['test'], $cases)) {
		$test->addTestFile("cases/$_GET[test]_test.php");
	} else {
		foreach ($cases as $case) $test->addTestFile("cases/${case}_test.php");
	}
	$test->run(new ExtendedHtmlReporter($cases));

	include 'cases/.teardown.php';
}
?>
