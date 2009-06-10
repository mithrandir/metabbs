<?php
permission_required('edit', $comment);

$post = $comment->get_post();
if (is_post()) {
	if (!$account->is_guest() || $comment->password == md5($_POST['password'])) {
		$comment->body = $_POST['body'];
		$comment->update();

		if (!is_xhr())
			redirect_to(url_for($post) . '#comment_' . $comment->id);
		else {
			$board = $comment->get_board();
			apply_filters('PostViewComment', $comment);
			$template = get_template($board, '_comment');
			$template->set('board', $board);
			$template->set('comment', $comment);
			$template->render_partial();
			exit;
		}
	} else {
		header('HTTP/1.1 403 Forbidden');
		print_notice('Failed to edit', 'Wrong password');
	}
} else {
	$template = get_template($board, 'edit_comment');
	$template->set('board', $board);
	$template->set('comment', $comment);
	$template->set('ask_password', $account->is_guest());
	$template->set('link_cancel', url_for($post));

	if (is_xhr()) {
		$template->render_partial();
		exit;
	}
}
?>
