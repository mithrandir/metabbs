<?php
require_once "../lib/finder.php";
require_once "../lib/model.php";
require_once "../app/models/board.php";
require_once "../app/models/post.php";

// TODO: ID를 비교하는 대신 직접 fixture와 비교하게 하기.

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
	function testGetPosts() {
		$board = Board::find(1);
		$posts = $board->get_posts(0, 10);
		$this->assertEqual(2, $posts[0]->id);
		$this->assertEqual(3, $posts[1]->id);
		$this->assertEqual(1, $posts[2]->id);
	}
	function testGetPostsInPage() {
		$board = Board::find(1);
		$posts = $board->get_posts_in_page(1);
		$this->assertEqual(2, $posts[0]->id);
		$this->assertEqual(3, $posts[1]->id);
		$this->assertEqual(1, $posts[2]->id);
	}
	function testGetFeedPosts() {
		$board = Board::find(1);
		$posts = $board->get_feed_posts(10);
		$this->assertEqual(3, $posts[0]->id);
		$this->assertEqual(2, $posts[1]->id);
		$this->assertEqual(1, $posts[2]->id);
	}
	function testGetPostCount() {
		$board = Board::find(1);
		$this->assertEqual(3, $board->get_post_count());
	}
	function testDelete() {
		$board = Board::find(1);
		$board->delete();
		$deleted_post = Post::find(1);
		$this->assertFalse($deleted_post->exists());
		$this->assertFalse($board->exists());
	}
}
?>
