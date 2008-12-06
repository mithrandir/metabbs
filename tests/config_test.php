<?php
require_once '../core/config.php';

class ConfigTest extends UnitTestCase {
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

	function testLoad() {
		$config = new Config('fixtures/test.conf');
		$this->assertEqual('1', $config->get('a'));
		$this->assertEqual('2', $config->get('b'));
		$this->assertEqual('default', $config->get('never', 'default'));
	}
	function testSave() {
		$config = new Config('fixtures/test.conf');
		$config->set('a', '123');
		$config->set('new', 'something');

		$this->assertEqual('123', $config->get('a'));
		$this->assertEqual('something', $config->get('new'));
		$config->write_to_file();
		unset($config);

		$config = new Config('fixtures/test.conf');
		$this->assertEqual('123', $config->get('a'));
		$this->assertEqual('something', $config->get('new'));
	}
}
?>
