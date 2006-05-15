<?php
if (!$id) {
    $controller = 'notice';
    $action = 'post';
}
$post = Post::find($id);
$board = $post->get_board();
?>
