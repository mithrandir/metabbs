<?php
$post = Post::find($id);
$board = $post->get_board();
?>
