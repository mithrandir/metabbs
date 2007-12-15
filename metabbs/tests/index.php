<?php
require 'simpletest/unit_tester.php';

$cases = array();
foreach (glob('*_test.php') as $case) {
	$cases[] = substr($case, 0, -9);
}

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

include '.setup.php';

$test = &new TestSuite('MetaBBS Tests');
if (isset($_GET['test']) && in_array($_GET['test'], $cases)) {
	$test->addTestFile("$_GET[test]_test.php");
} else {
	foreach ($cases as $case) $test->addTestFile("${case}_test.php");
}
$test->run(new ExtendedHtmlReporter($cases));

include '.teardown.php';
?>
