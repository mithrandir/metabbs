<?php
require_once "../lib/model.php";

class CachedModel {
	function CachedModel() {
		$this->id = uniqid('test'); // 인스턴스마다 달라짐
	}
	function find($id) {
		return new CachedModel;
	}
}

class ModelTest extends UnitTestCase {
	function testTableName() {
		set_table_prefix('meta_');
		$this->assertEqual("meta_test", get_table_name('test'));
		set_table_prefix('another_');
		$this->assertEqual("another_test", get_table_name('test'));
	}
	function testCachedFind() {
		$uncached = find_and_cache('CachedModel', 1);
		$cached = find_and_cache('CachedModel', 1);
		$this->assertEqual($cached->id, $uncached->id);
	}
	function testConstruct() {
		$model = new Model(array('test' => 'hi'));
		$this->assertEqual('hi', $model->test);
	}
}
?>
