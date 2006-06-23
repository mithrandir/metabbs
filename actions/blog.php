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

require_once 'lib/page.php';
$controller = 'board';
?>
