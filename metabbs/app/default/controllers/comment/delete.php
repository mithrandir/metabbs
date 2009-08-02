<?php
if (!$account->has_perm('delete', $comment))
	access_denied();

$_comment_deleted = false;
if (is_post()) {
	if (!$account->is_guest() || $comment->password == md5($params['password'])) {
		$comment->deleted_by = $account->is_guest() ? $comment->name : $account->name;
		TrashCan::put($comment, 'deleted by ' . $comment->deleted_by);
		$_comment_deleted = true;
	}
}
?>
