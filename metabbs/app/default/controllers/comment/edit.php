<?php
permission_required('comment', $post);

$_comment_edited = false;
if (is_post()) {
	if (isset($params['comment'])) {
		$params['comment'] = array(
			'name' => @$params['comment']['author'],
			'password' => @$params['comment']['password'],
			'body' => $params['comment']['body']
		);
	}
	$post_password = $params['comment']['password'];
	unset($params['comment']['password']);
	$comment->import($params['comment']);

	apply_filters('BeforeCommentUpdate', $comment, array('reply' => false));

	if ($account->is_guest() && !empty($comment->name))
		$error_messages->add('Please enter the name', 'author');

	if (empty($comment->body))
		$error_messages->add('Please enter the body', 'body');

	if ($account->is_guest()) {
		if (strlen($post_password) == 0)
			$error_messages->add('Please enter the password', 'password');
		else {
			if ($comment->password != md5($post_password))
				$error_messages->add('Please enter the valid password', 'password');
		}
	} else {
		if (!$account->is_admin() && $comment->user_id != $account->id)
			$error_messages->add('Wrong User');
	}

	if(!$error_messages->exists()) {
		$comment->update();
		$_comment_edited = true;
		if ($_comment_edited) {
			apply_filters('AfterCommentUpdate', $comment, array('reply' => false));
			cookie_register('name', $comment->name);
		}
	}
}
?>
