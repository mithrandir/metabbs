<?php
require_once "../lib/model.php";
require_once "../app/models/board.php";
require_once "../app/models/post.php";
require_once "../app/models/category.php";

class CategoryTest extends UnitTestCase {
	function setUp() {
		$this->category = Category::find(1);
	}

	function tearDown() {
		rollback();
	}

	function testFind() {
		$this->assertEqual(1, $this->category->id);
	}

	function testGetBoard() {
		$board = $this->category->get_board();
		$this->assertEqual(1, $board->id);
	}

	function testGetPostCount() {
		$this->assertEqual(1, $this->category->get_post_count());
	}

	function testDelete() {
		$this->category->delete();
		$post = Post::find(1);
		$this->assertEqual(0, $post->category_id);
		$this->assertFalse($this->category->exists());
	}
}
?>
