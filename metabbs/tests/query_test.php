<?php
require_once "../lib/backends/mock.php";
require_once "../lib/query.php";

class Person extends Model {
	function Person($data = array()) {
		$this->id = uniqid('test'); // 인스턴스마다 달라짐
		$this->Model($data);
	}
}

class QueryTest extends UnitTestCase {
	function setUp() {
		$this->origDB = $GLOBALS['__db'];
		$this->db =& new MockDatabase;
		$this->db->columns = array('blah', 'hello');
		$GLOBALS['__db'] =& $this->db;
		set_table_prefix('test_');
	}

	function tearDown() {
		$GLOBALS['__db'] = $this->origDB;
	}
	
	function testFind() {
		$this->db->data = array(array('id' => 42, 'name' => 'John Doe'));
		$person = find('person', 42);
		$this->assertIsA($person, 'Person');
		$this->assertEqual($person->id, 42);
		$this->assertEqual($person->name, 'John Doe');
	}
	
	function testCachedFind() {
		$uncached = find_and_cache('person', 1);
		$cached = find_and_cache('person', 1);
		$this->assertEqual($cached->id, $uncached->id);
	}
	
	function testFindBy() {
		$this->db->data = array(array('name' => 'John Doe', 'id' => 42));
		$person = find_by('person', 'name', 'John Doe');
		$this->assertEqual("SELECT * FROM test_person WHERE `name`='John Doe'", $this->db->query);
		$this->assertIsA($person, 'Person');
		$this->assertEqual(42, $person->id);
		$this->assertEqual('John Doe', $person->name);
	}
	
	function testFindAll() {
		$this->db->data = array(array('id' => 1, 'name' => '홍길동'), array('id' => 2, 'name' => '갑순이'));
		$people = find_all('person');
		$this->assertEqual("SELECT * FROM test_person", $this->db->query);
		$this->assertEqual(2, count($people));
		$this->assertEqual(1, $people[0]->id);
		$this->assertEqual('홍길동', $people[0]->name);
		$this->assertEqual(2, $people[1]->id);
		$this->assertEqual('갑순이', $people[1]->name);
	}
	
	function testFindAllWithCondition() {
		find_all('person', 'cond');
		$this->assertEqual("SELECT * FROM test_person WHERE cond", $this->db->query);
	}

	function testFindAllWithOrder() {
		find_all('person', 'cond', 'order');
		$this->assertEqual("SELECT * FROM test_person WHERE cond ORDER BY order", $this->db->query);
	}

	function testFindAllWithLimit() {
		find_all('person', 'cond', 'order', 10);
		$this->assertEqual("SELECT * FROM test_person WHERE cond ORDER BY order LIMIT 10", $this->db->query);

		find_all('person', 'cond', 'order', 10, 20);
		$this->assertEqual("SELECT * FROM test_person WHERE cond ORDER BY order LIMIT 20, 10", $this->db->query);
	}

	function testCountAll() {
		$this->db->data = array(array(10));
		$this->assertEqual(10, count_all('person'));
		$this->assertEqual("SELECT COUNT(*) FROM test_person", $this->db->query);

		$this->assertEqual(10, count_all('person', 'cond'));
		$this->assertEqual("SELECT COUNT(*) FROM test_person WHERE cond", $this->db->query);
	}

	function testDeleteAll() {
		delete_all('person');
		$this->assertEqual("DELETE FROM test_person", $this->db->query);

		delete_all('person', 'cond');
		$this->assertEqual("DELETE FROM test_person WHERE cond", $this->db->query);
	}

	function testInsert() {
		$id = insert('person', array('blah' => 123, 'hello' => 'world'));
		$this->assertEqual("INSERT INTO test_person (`blah`, `hello`) VALUES(123, 'world')", $this->db->query);
		$this->assertEqual(1, $id);
	}

	function testUpdateAll() {
		update_all('person', array('blah' => 123, 'hello' => 'world'));
		$this->assertEqual("UPDATE test_person SET `blah`=123, `hello`='world'", $this->db->query);
		update_all('person', array('blah' => 123, 'hello' => 'world'), 'cond');
		$this->assertEqual("UPDATE test_person SET `blah`=123, `hello`='world' WHERE cond", $this->db->query);
	}
}
