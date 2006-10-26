<?php
if ($board->perm_read > $account->level) {
	access_denied();
}
if (isset($_GET['search'])) {
	$board->search = array_merge($board->search, $_GET['search']);
}
$comments = $post->get_comments();
$attachments = $post->get_attachments();
$trackbacks = $post->get_trackbacks();

$name = cookie_get('name');
if ($post->user_id) {
	$user = $post->get_user();
	$signature = $user->signature;
} else {
	$signature = null;
}
apply_filters('PostView', $post);

$link_list = url_for($board, '', array('page' => get_requested_page()));
$link_new_post = ($account->level >= $board->perm_write) ? url_for($board, 'post') : null;

$owner = $post->user_id == 0 || $account->id == $post->user_id || $account->level >= $board->perm_delete;
if ($owner) {
	$link_edit = url_for($post, 'edit');
	$link_delete = url_for($post, 'delete');
}

$commentable = $board->perm_comment <= $account->level;

render('view');
?>
