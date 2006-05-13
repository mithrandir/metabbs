<?php
if ($board->perm_read > $user->level) {
	redirect_to(url_with_referer_for('user', 'login'));
}
$comments = $post->get_comments();
$attachments = $post->get_attachments();
$trackbacks = $post->get_trackbacks();
?>
