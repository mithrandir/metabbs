<?php
require 'simpletest/unit_tester.php';

$test = &new TestSuite('All tests');
$test->addTestFile('config_test.php');
$test->run(new HtmlReporter());
?>
