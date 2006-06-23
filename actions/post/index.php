<?php
if ($board->perm_read > $user->level) {
	access_denied();
}
$comments = $post->get_comments();
$attachments = $post->get_attachments();
$trackbacks = $post->get_trackbacks();

$nav[] = link_to(i("List"), $board, '', array('page' => get_requested_page()));
if ($user->level >= $board->perm_write) {
	$nav[] = link_to(i("New Post"), $board, 'post');
}
if ($post->user_id == 0 || $user->id == $post->user_id || $user->level >= $board->perm_delete) {
	$nav[] = link_to(i("Edit"), $post, 'edit');
	$nav[] = link_to(i("Delete"), $post, 'delete');
}

render('view');
?>
