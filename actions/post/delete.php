<?php
if (is_post() && ($user->level >= $board->perm_delete ||
        $post->password == md5($params['password']))) {
    $post->delete();
    redirect_to($board->get_href());
} else if ($post->user_id != 0 && $post->user_id == $user->id ||
        $user->level >= $board->perm_delete) {
    $action = 'admindelete';
}
?>
