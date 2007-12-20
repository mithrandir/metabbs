<?php
require_once "../lib/backends/mock.php";
require_once "../lib/finder.php";

class Person extends Model {
}

class FinderTest extends UnitTestCase {
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
		$people = find_all('person', 'cond');
		$this->assertEqual("SELECT * FROM test_person WHERE cond", $this->db->query);
	}
}
