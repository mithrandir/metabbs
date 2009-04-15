<?php
if (!empty($params['id'])) {
	$post = Post::find($params['id']);
	$board = $post->get_board();
	if ($params['board_name'] != $board->get_id()) {
		header('HTTP/1.1 404 Not Found');
		print_notice(i('Not matched board name'), i('The board name does not match.'));
	}
} else {
	if (!$params['board_name']) {
		header('HTTP/1.1 404 Not Found');
		print_notice(i('No board name'), i('Please append the board name.'));
	}
	requireCore('page');
	$board = Board::find_by_name($params['board_name']);
	if (!$board->exists()) {
		header('HTTP/1.1 404 Not Found');
		print_notice(i('Board not found'), i("Board %s doesn't exist.", !$params['id']));
	}
	$title = htmlspecialchars($board->get_title());
}
?>
