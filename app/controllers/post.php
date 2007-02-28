<?php
if (!isset($id)) {
	print_notice('No post id', 'Please append the post id.');
}
$post = Post::find($id);
if (!$post->exists()) {
	print_notice('Post not found', "Post #$id is not exist.");
}
if ($post->moved_to) {
	redirect_to(url_for(new Post(array('id' => $post->moved_to)), $action));
}
$board = $post->get_board();
$title = $board->get_title() . " - $post->title";
?>
