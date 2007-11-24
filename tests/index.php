<?php
require 'simpletest/unit_tester.php';

$cases = array('config', 'i18n', 'plugin_filter', 'plugin_handler');

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
?>
