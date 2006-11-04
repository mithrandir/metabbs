<?php
if (!$id) {
	print_notice('No board name', 'Please append the board name.');
}
require_once 'lib/page.php';
$board = Board::find_by_name($id);
if (!$board->exists()) {
	print_notice('Board not found', "Board <em>$id</em> is not exist.");
}
$title = $board->get_title();

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
