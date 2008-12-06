<?php
require_once '../core/plugin.php';

class PluginFilterTest extends UnitTestCase {
	function setUp() {
		add_filter('plugin_test', array(&$this, '_filter'), 0);
	}

	function tearDown() {
		remove_all_filters('plugin_test');
		unset($this->number);
	}

	function testApplyFilter() {
		$data = $this->_applyTestFilter();
		$this->assertEqual('ok', $data['test']);
		$this->assertEqual(123, $this->number);
	}

	function testFilterPriority() {
		add_filter('plugin_test', array(&$this, '_filter2'), 10);
		$data = $this->_applyTestFilter();
		$this->assertEqual('ok2', $data['test']);
		$this->assertEqual(123, $this->number);
	}

	function testFilterOverwrite() {
		add_filter('plugin_test', array(&$this, '_filter2'), 0, META_FILTER_OVERWRITE);
		$data = $this->_applyTestFilter();
		$this->assertEqual('ok2', $data['test']);
		$this->assertEqual(123, $this->number);
	}

	function testFilterPrepend() {
		add_filter('plugin_test', array(&$this, '_filter2'), 0, META_FILTER_PREPEND);
		$data = $this->_applyTestFilter();
		$this->assertEqual('ok', $data['test']);
		$this->assertEqual(123, $this->number);
	}

	function testFilterAppend() {
		add_filter('plugin_test', array(&$this, '_filter2'), 0, META_FILTER_APPEND);
		$data = $this->_applyTestFilter();
		$this->assertEqual('ok2', $data['test']);
		$this->assertEqual(123, $this->number);
	}

	function testFilterCollisionCallback() {
		add_filter('plugin_test', array(&$this, '_filter2'), 0, META_FILTER_CALLBACK, array(&$this, '_callback'));
		$data = $this->_applyTestFilter();
		$this->assertEqual('ok', $data['test']);
		$this->assertTrue($this->called);
		$this->assertEqual(123, $this->number);

		$this->called = FALSE;
		add_filter('plugin_test', array(&$this, '_filter2'), 10, META_FILTER_CALLBACK, array(&$this, '_callback'));
		$this->assertFalse($this->called);
	}

	function testRemoveFilter() {
		remove_filter('plugin_test', array(&$this, '_filter'));
		$data = $this->_applyTestFilter();
		$this->assertTrue(empty($data));
	}

	function testApplyFiltersArray() {
		$data = array(array(), array());
		apply_filters_array('plugin_test', $data, array('number' => 123));
		$this->assertEqual('ok', $data[0]['test']);
		$this->assertEqual('ok', $data[1]['test']);
	}

	function _applyTestFilter() {
		$data = array();
		apply_filters('plugin_test', $data, array('number' => 123));
		return $data;
	}
	function _filter(&$data, $args) {
		$data['test'] = 'ok';
		$this->number = $args['number'];
	}
	function _filter2(&$data, $args) {
		$data['test'] = 'ok2';
		$this->number = $args['number'];
	}
	function _callback() {
		$this->called = TRUE;
	}
}
?>
