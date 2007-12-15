<?php
require_once "../lib/model.php";
require_once "../app/models/board.php";

class BoardTest extends UnitTestCase {
	function testFind() {
		$board = Board::find(1);
		$this->assertEqual(1, $board->id);
	}
	function testFindByName() {
		$board = Board::find_by_name('test');
		$this->assertEqual(1, $board->id);
	}
	function testFindAll() {
		$boards = Board::find_all();
		$this->assertEqual(1, $boards[0]->id);
		$this->assertEqual(2, $boards[1]->id);
	}
	function testValidate() {
		$board = new Board(array('name' => 'valid'));
		$this->assertTrue($board->validate());

		$board2 = new Board(array('name' => 'test'));
		$this->assertFalse($board2->validate());
	}
	function testGetTitle() {
		$board = new Board(array('name' => 'test'));
		$this->assertEqual('test', $board->get_title());
		$board->title = 'title';
		$this->assertEqual('title', $board->get_title());
	}
}
?>
