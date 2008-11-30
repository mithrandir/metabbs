<?php
$template = $style->get_template('view');
$template->set('attachments', $post->get_attachments());
$template->set('trackbacks', $post->get_trackbacks());
$template->set('name', cookie_get('name'));

if (isset($user) && $user->exists() && $user->signature)
	$template->set('signature', format_plain($user->signature));

$template->set('board', $board);
$template->set('post', $post);
$template->set('captcha', $captcha);
$template->set('older_post', $older_post);
$template->set('newer_post', $newer_post);
$template->set('comments', $comments);

//$params = get_search_params();
$_params = get_search_params();
if (isset($_params['page']))
	$_params['page'] = $post->get_page();
$_params['board-name'] = $board->name;
//$template->set('link_list', url_for($board, '', $params));
//$template->set('link_new_post', $account->has_perm('write', $board) ? url_for($board, 'post', $params) : null);
//$template->set('link_edit', $account->has_perm('edit', $post) ? url_for($post, 'edit', $params) : '');
//$template->set('link_delete', $account->has_perm('delete', $post) ? url_for($post, 'delete', $params) : '');
$template->set('link_list', url_for_metabbs('board', null, $_params));
$template->set('link_new_post', $account->has_perm('write', $board) ? url_for_metabbs('board', 'post', $_params) : null);

$_params['id'] = $post->id;
$template->set('link_edit', $account->has_perm('edit', $post) ? url_for_metabbs('post', 'edit', $params) : '');
$template->set('link_delete', $account->has_perm('delete', $post) ? url_for_metabbs('post', 'delete', $params) : '');
$template->set('commentable', $account->has_perm('comment', $post));
$template->render();
