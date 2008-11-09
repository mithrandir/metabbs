<?php
if (!$params['board-name']) {
	header('HTTP/1.1 404 Not Found');
	print_notice(i('No board name'), i('Please append the board name.'));
}
require 'core/page.php';
$board = Board::find_by_name($params['board-name']);
if (!$board->exists()) {
	header('HTTP/1.1 404 Not Found');
	print_notice(i('Board not found'), i("Board %s doesn't exist.", $params['board-name']));
}
$title = htmlspecialchars($board->get_title());
?>
