<?php
require_once "../lib/model.php";
require_once "../app/models/board.php";
require_once "../app/models/post.php";
require_once "../app/models/comment.php";

class CommentTest extends UnitTestCase {
	function testFind() {
		$comment = Comment::find(1);
		$this->assertEqual(1, $comment->id);
	}

	function testGetPost() {
		$comment = Comment::find(1);
		$post = $comment->get_post();
		$this->assertEqual(1, $post->id);
	}

	function testGetBoard() {
		$comment = Comment::find(1);
		$board = $comment->get_board();
		$this->assertEqual(1, $board->id);
	}

	function testGetParent() {
		$child = Comment::find(3);
		$parent = $child->get_parent();
		$this->assertEqual(1, $parent->id);
		$this->assertNull($parent->get_parent());
	}

	function testHasChild() {
		$child = Comment::find(3);
		$parent = $child->get_parent();
		$this->assertTrue($parent->has_child());
		$this->assertFalse($child->has_child());
	}
}
?>
