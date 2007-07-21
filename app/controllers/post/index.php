<?php
permission_required('read', $post);

if (isset($_GET['search'])) {
	$board->search = array_merge($board->search, $_GET['search']);
}
$seen_posts = explode(',', cookie_get('seen_posts'));
if (!in_array($post->id, $seen_posts)) {
	$post->update_view_count();
	$seen_posts[] = $post->id;
	cookie_register('seen_posts', implode(',', $seen_posts));
}

$template = get_template($board, 'view');
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
$template->set('link_new_post', $account->has_perm('write', $board) ? url_for($board, 'post') : null);

$template->set('link_edit', $account->has_perm('edit', $post) ? url_for($post, 'edit') : '');
$template->set('link_delete', $account->has_perm('delete', $post) ? url_for($post, 'delete') : '');

$template->set('commentable', $account->has_perm('comment', $post));

$template->set('newer_post', $post->get_newer_post());
$template->set('older_post', $post->get_older_post());
?>
