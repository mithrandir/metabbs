<?php
permission_required('comment', $post);

if (is_post()) {
	if (isset($params['comment'])) {
		$params['comment'] = array(
			'name' => @$params['comment']['author'],
			'password' => @$params['comment']['password'],
			'body' => $params['comment']['body']
		);
	}

	$comment = new Comment($params['comment']);
	if (!$account->is_guest()) {
		$comment->user_id = $account->id;
		$comment->name = $account->name;
	} else {
		cookie_register('name', $comment->name);
	}

	$comment->post_id = $post->id;

	apply_filters('BeforeCommentCreate', $comment, array('reply' => false));
	apply_filters('ValidateCommentCreate', $params, $error_messages);

	if ($account->is_guest() && empty($comment->name))
		$error_messages->add('Please enter the name', 'author');

	if (empty($comment->body))
		$error_messages->add('Please enter the body', 'body');

	if ($account->is_guest() && empty($comment->password))
		$error_messages->add('Please enter the password', 'password');

	if (!$error_messages->exists()) {
		$post->add_comment($comment);
		apply_filters('AfterCommentCreate', $comment, array('reply' => false));
		if (!is_xhr())
			redirect_to(url_for($post));
	}	
}
?>
