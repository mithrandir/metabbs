<?php
permission_required('comment', $post);

$_comment_added = false;
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
	}
	$comment->post_id = $post->id;

	apply_filters('BeforeCommentCreate', $comment, array('reply' => false));
//	apply_filters('ValidateCommentCreate', $params, $error_messages);

	if (empty($comment->name))
		$error_messages->add('Please enter the name', 'author');

	if (empty($comment->body))
		$error_messages->add('Please enter the body', 'body');

	if ($account->is_guest() && strlen($comment->password) == 0)
			$error_messages->add('Please enter the password', 'password');

	if(!$error_messages->exists()) {
		$post->add_comment($comment);
		$_comment_added = true;
		if ($_comment_added) {
			apply_filters('AfterCommentCreate', $comment, array('reply' => false));
			cookie_register('name', $comment->name);
		}
	}	
}
?>
