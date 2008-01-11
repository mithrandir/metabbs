<?php
require_once '../lib/plugin.php';

class PluginFilterTest extends UnitTestCase {
	function setUp() {
		add_filter('plugin_test', array(&$this, '_filter'), 0);
	}

	function tearDown() {
		remove_all_filters('plugin_test');
	}

	function testApplyFilter() {
		$data = $this->_applyTestFilter();
		$this->assertEqual('ok', $data['test']);
	}

	function testFilterPriority() {
		add_filter('plugin_test', array(&$this, '_filter2'), 10);
		$data = $this->_applyTestFilter();
		$this->assertEqual('ok2', $data['test']);
	}

	function testFilterOverwrite() {
		add_filter('plugin_test', array(&$this, '_filter2'), 0, META_FILTER_OVERWRITE);
		$data = $this->_applyTestFilter();
		$this->assertEqual('ok2', $data['test']);
	}

	function testFilterPrepend() {
		add_filter('plugin_test', array(&$this, '_filter2'), 0, META_FILTER_PREPEND);
		$data = $this->_applyTestFilter();
		$this->assertEqual('ok', $data['test']);
	}

	function testFilterAppend() {
		add_filter('plugin_test', array(&$this, '_filter2'), 0, META_FILTER_APPEND);
		$data = $this->_applyTestFilter();
		$this->assertEqual('ok2', $data['test']);
	}

	function testFilterCollisionCallback() {
		add_filter('plugin_test', array(&$this, '_filter2'), 0, META_FILTER_CALLBACK, array(&$this, '_callback'));
		$data = $this->_applyTestFilter();
		$this->assertEqual('ok', $data['test']);
		$this->assertTrue($this->called);

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
		apply_filters_array('plugin_test', $data);
		$this->assertEqual('ok', $data[0]['test']);
		$this->assertEqual('ok', $data[1]['test']);
	}

	function _applyTestFilter() {
		$data = array();
		apply_filters('plugin_test', $data);
		return $data;
	}
	function _filter(&$data) {
		$data['test'] = 'ok';
	}
	function _filter2(&$data) {
		$data['test'] = 'ok2';
	}
	function _callback() {
		$this->called = TRUE;
	}
}
?>
