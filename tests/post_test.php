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

	function testGetAttribute() {
		$post = Post::find(1);
		$this->assertEqual('', $post->get_attribute('no'));
	}

	function testSetAttribute() {
		$post = Post::find(1);
		$post->set_attribute('foo', 'bar');
		$this->assertEqual('bar', $post->get_attribute('foo'));
		$post->set_attribute('foo', 'baz');
		$this->assertEqual('baz', $post->get_attribute('foo'));
	}

	function testGetAttributes() {
		$post = Post::find(2);
		$this->assertEqual(array(), $post->get_attributes());

		$post->set_attribute('first', '1');
		$post->set_attribute('second', '2');
		$attributes = $post->get_attributes();
		$this->assertEqual('1', $attributes['first']);
		$this->assertEqual('2', $attributes['second']);
	}
}
