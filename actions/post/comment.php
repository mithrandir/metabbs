<?php
$comment = new Comment($params['comment']);
$comment->post_id = $post->id;
$_SESSION['name'] = $comment->name;
$comment->save();
redirect_to($post->get_href());
?>
