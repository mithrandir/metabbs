<?php
if (!$account->has_perm('delete', $comment))
	access_denied();

$_comment_deleted = false;
if (is_post()) {
	apply_filters('BeforeCommentDelete', $comment);

	if ($account->is_guest()) {
		if ($comment->password != md5($params['password']))
			$error_messages->add('The Password does not matched', 'password');
	} else {
		if (!$account->is_admin() && $comment->user_id != $account->id) {
			$error_messages->add('Invalid Owner');
		}
	}

	if (!$error_messages->exists()) {
		$comment->deleted_by = $account->is_guest() ? $comment->name : $account->name;
		TrashCan::put($comment, 'deleted by ' . $comment->deleted_by);
		$_comment_deleted = true;
		apply_filters('AfterCommentDelete', $comment);
	}
}
?>
