<?php
class Blog extends Board
{
	function find_by_name($name) {
		$board = Board::find_by_name($name);
		$blog = new Blog(get_object_vars($board));
		return $blog;
	}
	function get_model_name() {
		return "board";
	}
	function get_href() {
		return "blog";
	}
}

$board = Blog::find_by_name("blog"); //XXX

if (!isset($id)) {
	if ($action != 'rss')
		$controller = 'board';
} else {
	$post = Post::find($id);
	$controller = 'post';
}
?>
