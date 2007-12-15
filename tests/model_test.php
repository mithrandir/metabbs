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

class Animal extends Model {
	var $model = 'animal';
}

class MockDatabase {
	var $sequence = 1;

	function get_columns($table) {
		return $this->columns;
	}
	function quote_identifier($id) {
		return "`$id`";
	}
	function quote($value) {
		if (is_numeric($value)) return $value;
		else return "'".$this->escape($value)."'";
	}
	function escape($string) {
		return addslashes($string);
	}
	function query($query) {
		$this->query = $query;
	}
	function execute($query) {
		$this->query = $query;
	}
	function insertid() {
		return $this->sequence++;
	}
}

class ModelTest extends UnitTestCase {
	function setUp() {
		$this->db =& new MockDatabase;
		$this->db->columns = array('blah', 'hello');
		$GLOBALS['__db'] =& $this->db;
		set_table_prefix('test_');
	}
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
	function testImport() {
		$model = new Model;
		$this->assertTrue($model->import(array('test' => 'hi')));
		$this->assertEqual('hi', $model->test);
		$this->assertFalse($model->import(123));
	}
	function testExists() {
		$model = new Model;
		$this->assertFalse($model->exists());
		$model->id = 123;
		$this->assertTrue($model->exists());
	}
	function testGetID() {
		$model = new Model(array('id' => 123));
		$this->assertEqual(123, $model->get_id());
	}
	function testCreate() {
		$model = new Animal(array('blah' => 123, 'hello' => 'world'));
		$model->create();
		$this->assertEqual("INSERT INTO test_animal (`blah`, `hello`) VALUES(123, 'world')", $this->db->query);
		$this->assertEqual(1, $model->id);
	}
	function testUpdate() {
		$model = new Animal(array('id' => 42, 'blah' => 123, 'hello' => 'world'));
		$model->update();
		$this->assertEqual("UPDATE test_animal SET `blah`=123, `hello`='world' WHERE id=42", $this->db->query);
	}
	function testDelete() {
		$model = new Animal(array('id' => 42));
		$model->delete();
		$this->assertEqual("DELETE FROM test_animal WHERE id=42", $this->db->query);
	}
}
?>
