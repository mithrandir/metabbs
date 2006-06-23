<?php
if (!$id) {
	print_notice('No board name', 'Please append the board name.');
}
require_once 'lib/page.php';
$board = Board::find_by_name($id);
if (!$board->exists()) {
	print_notice('Board not found', "Board <em>$id</em> is not exist.");
}
?>
