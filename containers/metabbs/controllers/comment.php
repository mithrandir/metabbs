<?php
$comment = Comment::find($params['id']);
$board = $comment->get_board();
?>
