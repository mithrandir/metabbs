<?php
permission_required('reply', $comment);

if (is_post() && !isset($_POST['comment'])) {
	$_POST['comment'] = array(
		'name' => $_POST['author'],
		'password' => $_POST['password'],
		'body' => $_POST['body']
	);
}

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
	$post = $comment->get_post();
	apply_filters('PostComment', $_comment, array('reply' => TRUE));
	apply_filters('ValidateCommentReply', $_POST, $error_messages);

	if (empty($post->name))
		$error_messages->add('Please enter the name', 'author');

	if (empty($post->body))
		$error_messages->add('Please enter the body', 'body');

	if ($account->is_guest() && strlen($post->password) < 5)
			$error_messages->add('Password length must be longer than 5', 'password');

	if(!$error_messages->exists()) {
		$post->add_comment($_comment);

		apply_filters('AfterPostComment', $comment, array('reply' => TRUE));

		if (is_xhr()) {
			apply_filters('PostViewComment', $_comment);
			$template = get_template($board, '_comment');
			$template->set('board', $board);
			$template->set('error_messages', $error_messages);
			$template->set('comment', $_comment);
			$template->render_partial();
			exit;
		} else {
			redirect_to(url_for($post));
		}
	}
} else {
	$post = $comment->get_post();

	$template = get_template($board, 'reply');
	$template->set('board', $board);
	$template->set('error_messages', $error_messages);
	$template->set('comment', $comment);
	$template->set('name', cookie_get('name'));
	$template->set('link_cancel', url_for($post));

	if (is_xhr()) {
		$template->render_partial();
		exit;
	}
}
?>
