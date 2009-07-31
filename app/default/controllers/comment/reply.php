<?php
permission_required('reply', $comment);

$_comment_replied = false;
if (is_post()) {
	if (isset($params['comment'])) {
		$params['comment'] = array(
			'name' => @$params['comment']['author'],
			'password' => @$params['comment']['password'],
			'body' => $params['comment']['body']
		);
	}

	$_comment = new Comment($params['comment']);
	$_comment->parent = $comment->id;
	if (!$account->is_guest()) {
		$_comment->user_id = $account->id;
		$_comment->name = $account->name;
	} else {
		cookie_register('name', $_comment->name);
	}

	apply_filters('ValidateCommentReply', $params, $error_messages);
	apply_filters('BeforeCommentReply', $comment, array('reply' => false));

	if ($account->is_guest() && !empty($_comment->name))
		$error_messages->add('Please enter the name', 'author');

	if (empty($_comment->body))
		$error_messages->add('Please enter the body', 'body');

	if ($account->is_guest() && strlen($post_password) == 0)
			$error_messages->add('Please enter the password', 'password');

	if(!$error_messages->exists()) {
		$post->add_comment($_comment);
		$_comment_replied = true;
		if ($_commen_comment_repliedt_edited) {
			apply_filters('AfterCommentReply', $comment, array('reply' => false));
			cookie_register('name', $comment->name);
		}
	}
}
?>
