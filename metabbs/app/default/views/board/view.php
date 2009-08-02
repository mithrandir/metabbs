<?php
$template = $style->get_template('view');
$template->set('attachments', $post->get_attachments());
$template->set('attachment_downable', $account->has_perm('attachment', $post));
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
$template->set('comment_url', url_for($post, 'comment'));
$template->set('comment_writable', $account->has_perm('write_comment', $post));
$template->set('commentable', $account->has_perm('comment', $post));
//$template->set('comment', array('name'=>null, 'body'=>null));
$template->set('comment_author', null);
$template->set('comment_body', null);
$template->set('show_list', $show_list);
if ($show_list)
	include dirname(__FILE__) . '/_list.php';

$template->render();
