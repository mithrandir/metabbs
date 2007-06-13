<?php
if (!$account->is_admin()) {
	access_denied();
}

if (is_post()) {
	$_board = new Board(array('id' => $_POST['board_id']));
	$post->move_to($_board);
	redirect_to(url_for($post));
} else {
	$boards = Board::find_all();
}
?>
