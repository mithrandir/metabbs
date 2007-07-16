<?php
if ($board->perm_read > $account->level) {
	access_denied();
}
if ($post->secret) {
	if ($post->user_id != $account->id && !$account->is_admin()) {
		access_denied();
	} else if ($post->user_id == 0 && $account->is_guest()) {
		if (is_post() && md5($_POST['password']) == $post->password) {
		} else {
			$template = $board->get_style()->get_template('secret');
			$template->set('board', $board);
			return;
		}
	}
}

if (isset($_GET['search'])) {
	$board->search = array_merge($board->search, $_GET['search']);
}
$seen_posts = explode(',', cookie_get('seen_posts'));
if (!in_array($post->id, $seen_posts)) {
	$post->update_view_count();
	$seen_posts[] = $post->id;
	cookie_register('seen_posts', implode(',', $seen_posts));
}

$template = $board->get_style()->get_template('view');
$template->set('attachments', $post->get_attachments());
$template->set('trackbacks', $post->get_trackbacks());
$template->set('name', cookie_get('name'));

if ($post->user_id) {
	$user = $post->get_user();
	if ($user->exists() && $user->signature)
		$template->set('signature', format_plain($user->signature));
}
apply_filters('PostView', $post);
$template->set('board', $board);
$template->set('post', $post);

$comments = $post->get_comments();
apply_filters_array('PostViewComment', $comments);
$template->set('comments', $comments);

$template->set('link_list', url_for($board, '', array('page' => $post->get_page())));
$template->set('link_new_post', ($account->level >= $board->perm_write) ? url_for($board, 'post') : null);

$template->set('owner', $owner = $post->user_id == 0 || $account->id == $post->user_id || $account->level >= $board->perm_delete);
if ($owner) {
	$template->set('link_edit', url_for($post, 'edit'));
	$template->set('link_delete', url_for($post, 'delete'));
}

$template->set('commentable', $board->perm_comment <= $account->level);

$template->set('newer_post', $post->get_newer_post());
$template->set('older_post', $post->get_older_post());
?>
