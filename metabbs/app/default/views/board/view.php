<?php
$template = $style->get_template('view');
$template->set('attachments', $post->get_attachments());
$template->set('trackbacks', $post->get_trackbacks());
$template->set('name', cookie_get('name'));

if (isset($user) && $user->exists() && $user->signature)
	$template->set('signature', format_plain($user->signature));

$template->set('board', $board);
$template->set('post', $post);
$template->set('older_post', $older_post);
$template->set('newer_post', $newer_post);
$template->set('comments', $comments);
$template->set('error_messages', $error_messages);

$params = get_search_params();
if (!isset($params['page']))
	$params['page'] = $post->get_page();
$template->set('link_list', url_for($board, null, $params));
$template->set('link_new_post', $account->has_perm('write', $board) ? url_for($board, 'post', $params) : null);
$template->set('link_edit', $account->has_perm('edit', $post) ? url_for($post, 'edit', $params) : '');
$template->set('link_delete', $account->has_perm('delete', $post) ? url_for($post, 'delete', $params) : '');
$template->set('commentable', $account->has_perm('comment', $post));
$template->render();
