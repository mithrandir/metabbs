<?php
$comment = new Comment($params['comment']);
$comment->post_id = $post->id;
if ($user->level < $board->perm_comment) {
    redirect_to(url_for($post));
}
$comment->user_id = $user->id;
if ($user->is_guest()) {
    cookie_register('name', $comment->name);
} else {
    $comment->name = $user->name;
}
$comment->save();
if (isset($params['ajax'])) {
    include($_skin_dir . 'comment/_comment.php');
    exit;
} else {
    redirect_to(url_for($post));
}
?>
