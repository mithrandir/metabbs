<?php
class Blog extends Board
{
	var $model = 'blog';

	function get_id() { return ""; }
	function find_by_name($name) {
		$db = get_conn();
		$table = get_table_name('board');
		return $db->fetchrow("SELECT * FROM $table WHERE name='$name'", 'Blog');
	}
}

$board = Blog::find_by_name('blog'); //XXX

require_once 'core/page.php';
$controller = 'board';
$layout->title = htmlspecialchars($board->get_title());
?>
