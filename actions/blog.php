<?php
class Blog extends Board
{
	function get_model_name() {
		return "board";
	}
	function get_href() {
		return "blog";
	}
}

$board = new Blog("blog", "name");

require_once 'lib/page.php';
$controller = 'board';
?>
