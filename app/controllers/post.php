<?php
if (!isset($id)) {
	header('HTTP/1.1 404 Not Found');
	print_notice(i('No post id'), i('Please append the post id.'));
}
$post = Post::find($id);
if (!$post->exists()) {
	header('HTTP/1.1 404 Not Found');
	print_notice(i('Post not found'), i("Post #%d doesn't exist.", $id));
}
if ($post->moved_to) {
	redirect_to(url_for(new Post(array('id' => $post->moved_to)), $action));
}
$board = $post->get_board();
$title = $board->get_title() . " - $post->title";
?>
