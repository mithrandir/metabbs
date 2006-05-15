<?php
$post = $comment->get_post();
if (is_post() && ($user->level >= $board->perm_delete ||
        $comment->password == md5($params['password']))) {
    $comment->delete();
    redirect_to($post->get_href());
} else if ($comment->user_id != 0 && $comment->user_id == $user->id ||
        $user->level >= $board->perm_delete) {
    $action = 'admindelete';
}
?>
