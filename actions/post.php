<?php
if (!isset($id)) {
	print_notice('No post id', 'Please append the post id.');
}
$post = Post::find($id);
if (!$post->exists()) {
	print_notice('Post not found', "Post #$id is not exist.");
}
$board = $post->get_board();
$title = $board->get_title() . " - $post->title";

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
