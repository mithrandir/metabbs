<?php
permission_required('reply', $comment);

if (is_post()) {
	$_comment = new Comment($_POST['comment']);
	$_comment->user_id = $account->id;
	$_comment->post_id = $comment->post_id;
	$_comment->parent = $comment->id;
	if (!$_comment->valid()) {
		exit;
	}
	if (!$account->is_guest()) {
		$_comment->name = $account->name;
	} else {
		cookie_register('name', $_comment->name);
	}

	apply_filters('PostComment', $_comment);

	$post = $comment->get_post();
	$post->add_comment($_comment);

	if (is_xhr()) {
		apply_filters('PostViewComment', $_comment);
		$template = get_template($board, '_comment');
		$template->set('board', $board);
		$template->set('comment', $_comment);
		$template->render();
		exit;
	} else {
		redirect_to(url_for($post));
	}
} else {
	$template = get_template($board, 'reply');
	$template->set('comment', $comment);
	$template->set('name', cookie_get('name'));
	if (is_xhr()) {
		$template->render();
		exit;
	}
}
?>
