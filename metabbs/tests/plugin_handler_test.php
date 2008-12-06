<?php
require_once "../core/plugin.php";

class PluginHandlerTest extends UnitTestCase {
	function setUp() {
		reset_custom_handler();
		if (isset($this->called)) {
			unset($this->called);
		}
	}

	function testNoHandler() {
		$hooked = run_custom_handler('test', 'hello');
		$this->assertEqual(FALSE, $hooked);
	}

	function testBeforeHandler() {
		add_handler('test', 'hello', array(&$this, '_callback'), 'before');
		$hooked = run_custom_handler('test', 'hello');
		$this->assertEqual(FALSE, $hooked);
		$this->assertEqual(TRUE, $this->called);
	}

	function testHookHandler() {
		add_handler('test', 'hello', array(&$this, '_callback'));
		$hooked = run_custom_handler('test', 'hello');
		$this->assertEqual(TRUE, $hooked);
		$this->assertEqual(TRUE, $this->called);
	}

	function testBeforeAndHookHandler() {
		add_handler('test', 'hello', array(&$this, '_callback'), 'before');
		add_handler('test', 'hello', array(&$this, '_callback2'));
		$hooked = run_custom_handler('test', 'hello');
		$this->assertEqual(TRUE, $hooked);
		$this->assertEqual('hooked', $this->called);
	}

	function _callback() {
		$this->called = TRUE;
	}
	function _callback2() {
		$this->called = 'hooked';
	}
}
?>
