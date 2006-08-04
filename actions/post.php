<?php
if (!isset($id)) {
	print_notice('No post id', 'Please append the post id.');
}
$post = new Post($id);
if (!$post->exists()) {
	print_notice('Post not found', "Post #$id is not exist.");
}
$board = $post->get_board();
?>
