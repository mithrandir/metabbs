<?php
class Blog extends Board
{
	var $model = 'blog';

	function find_by_name($name) {
		$db = get_conn();
		$table = get_table_name('board');
		return $db->fetchrow("SELECT * FROM $table WHERE name='$name'", 'Blog');
	}
}

$board = Blog::find_by_name('blog'); //XXX

require_once 'lib/page.php';
$controller = 'board';
?>
