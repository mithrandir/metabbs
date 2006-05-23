<?php
if ($board->perm_read > $user->level) {
	access_denied();
}
$comments = $post->get_comments();
$attachments = $post->get_attachments();
$trackbacks = $post->get_trackbacks();

render('view');
?>
