<?php
require_once ('../lib/backends/mysql/backend.php');

class MysqlTest extends UnitTestCase {
	function setUp() {
	$fp = fopen('fixtures/test.conf', 'w');
	fwrite($fp, "<"."?php/*\n");
	fwrite($fp, "a=1\n");
	fwrite($fp, "b=2\n");
	fclose($fp);
	}
	function tearDown() {
		unlink('fixtures/test.conf');
	}
}
?>
