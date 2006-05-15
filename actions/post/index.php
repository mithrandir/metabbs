<?php
if ($board->perm_read > $user->level) {
    redirect_to(url_for('user', 'login', array(), true));
}
$comments = $post->get_comments();
$attachments = $post->get_attachments();
$trackbacks = $post->get_trackbacks();
?>
