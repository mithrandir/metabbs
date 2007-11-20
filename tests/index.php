<?php
require 'simpletest/unit_tester.php';

class ExtendedHtmlReporter extends HtmlReporter {
	function ExtendedHtmlReporter($cases) {
		$this->cases = $cases;
	}
	function paintHeader($test_name) {
		HtmlReporter::paintHeader($test_name);
		echo "<ul>";
		foreach ($this->cases as $case) {
			echo "<li><a href=\"?test=$case\">$case</a></li>";
		}
		echo "</ul>";
	}
}

$cases = array('config', 'i18n', 'plugin_filter');

$test = &new TestSuite('All tests');
if (isset($_GET['test']) && in_array($_GET['test'], $cases)) {
	$test->addTestFile("$_GET[test]_test.php");
} else {
	foreach ($cases as $case) $test->addTestFile("${case}_test.php");
}
$test->run(new ExtendedHtmlReporter($cases));
?>
