<?php
authz_require($account, 'read', $post);

if (isset($_GET['search'])) {
	$board->search = array_merge($board->search, $_GET['search']);
}
$seen_posts = explode(',', cookie_get('seen_posts'));
if (!in_array($post->id, $seen_posts)) {
	$post->update_view_count();
	$seen_posts[] = $post->id;
	cookie_register('seen_posts', implode(',', $seen_posts));
}

$comments = $post->get_comments();
$attachments = $post->get_attachments();
$trackbacks = $post->get_trackbacks();

$name = cookie_get('name');
if ($post->user_id) {
	$user = $post->get_user();
	if ($user->exists() && $user->signature)
		$signature = format_plain($user->signature);
}
apply_filters('PostView', $post);
apply_filters_array('PostViewComment', $comments);

$link_list = url_for($board, '', array(
	'page' => 1 + floor($board->get_post_count_with_condition("id > ? AND type >= ?", array($post->id, $post->type)) / $board->posts_per_page)
));
$link_new_post = $account->has_perm('write', $board) ? url_for($board, 'post') : null;
$link_edit = $account->has_perm('edit', $post) ? url_for($post, 'edit') : null;
$link_delete = $account->has_perm('delete', $post) ? url_for($post, 'delete') : null;
$owner = $link_edit && $link_delete;
$commentable = $account->has_perm('comment', $post);

$newer_post = $post->get_newer_post();
$older_post = $post->get_older_post();
?>
