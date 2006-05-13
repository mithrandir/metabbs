<?php
if ($board->perm_write > $user->level) {
	redirect_to(url_for('user', 'login', true));
}
if (is_post()) {
	$post = new Post($_POST['post']);
	$post->board_id = $board->id;
	define('SECURITY', 1);
	include 'actions/post/save.php';
} else {
	$post = new Post;
}
?>
