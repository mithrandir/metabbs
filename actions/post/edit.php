<?php
if ($post->user_id != 0 && $user->id != $post->user_id
        && $board->perm_delete > $user->level) {
    redirect_to(url_for('user', 'login', true));
}
if (is_post()) {
    if ($post->user_id == 0 && $board->perm_delete > $user->level) {
        if ($post->password != md5($params['post']['password'])) {
            redirect_to(url_for($post, 'edit'));
        }
    }

    $post->import($params['post']);
    if ($params['delete']) {
        foreach ($params['delete'] as $id) {
            $attachment = Attachment::find($id);
            $attachment->delete();
            @unlink('data/uploads/'.$id);
        }
    }
    define('SECURITY', 1);
    include 'actions/post/save.php';
}
?>
