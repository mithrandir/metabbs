<?php
$comment = Comment::find($id);
$board = $comment->get_board();
?>
