<?php
if($_comment_deleted) {
	if (is_xhr()) {
		$template = get_template($board, '_comment');
		apply_filters('PostViewComment', $comment);
		$template->set('board', $board);
		$template->set('comment_url', url_for($comment, 'reply'));
		$template->set('comment', $comment);
		$template->set('error_messages', $error_messages);
		$template->render_partial();
		exit;
	} else {
		redirect_to(url_for($post));
	}
} else {
	$template = get_template($board, 'delete');
	$template->set('board', $board);
	$template->set('comment', $comment);
	$template->set('ask_password', $account->is_guest());
	$template->set('link_cancel', url_for($post));
	$template->render();
}
