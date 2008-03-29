<?php
require_once "../lib/model.php";
require_once "../app/models/board.php";
require_once "../app/models/category.php";
require_once "../app/models/post.php";
require_once "../app/models/comment.php";

class PostTest extends UnitTestCase {
	function tearDown() {
		global $__cache;
		$__cache->reset();
	}

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

	function testGetCategory() {
		$post = Post::find(1);
		$category = $post->get_category();
		$this->assertEqual(1, $category->id);
		$post2 = Post::find(2);
		$this->assertNull($post2->get_category());
	}

	function testGetComments() {
		$post = Post::find(1);
		$comments = $post->get_comments(false);
		$this->assertEqual(1, $comments[0]->id);
		$this->assertEqual(2, $comments[1]->id);
		$this->assertEqual(3, $comments[2]->id);
	}

	function testGetCommentTree() {
		$post = Post::find(1);
		$comments = $post->get_comments();
		$this->assertEqual(1, $comments[0]->id);
		$this->assertEqual(2, $comments[1]->id);
		$this->assertEqual(3, $comments[0]->comments[0]->id);
	}
}
