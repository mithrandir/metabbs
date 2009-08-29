<?php
// if the comment has been created, $comment->exists() == TRUE
if ($comment->exists() && is_xhr()) {
	$template = get_template($board, '_comment');
	apply_filters('PostViewComment', $comment);
	$template->set('board', $board);
	$template->set('comment', $comment);
	$template->set('error_messages', $error_messages);
	$template->render_partial();
	exit;
} else {
	$style = $board->get_style();
	$template = $style->get_template('comment');
	$template->set('board', $board);
	$template->set('post', $post);
	$template->set('comment_url', url_for($post, 'comment'));
	$template->set('comment_writable', $account->has_perm('write_comment', $post));
	$template->set('commentable', $account->has_perm('comment', $post));
	$template->set('comment_author', $comment->name);
	$template->set('comment_body', $comment->body);
	$template->set('link_cancel', url_for($post, null, get_search_params()));
	$template->set('error_messages', $error_messages);
	$template->render();
}
