<?php
require_once "../lib/finder.php";
require_once "../lib/model.php";
require_once "../app/models/board.php";
require_once "../app/models/post.php";

class PostTest extends UnitTestCase {
	function testFind() {
		$post = Post::find(1);
		$this->assertEqual(1, $post->id);
	}
	function testIsNotice() {
		$post = Post::find(1);
		$this->assertFalse($post->is_notice());
		$notice = Post::find(2);
		$this->assertTrue($notice->is_notice());
	}
	function testGetBoard() {
		$post = Post::find(1);
		$board = $post->get_board();
		$this->assertEqual(1, $board->id);
	}
}
