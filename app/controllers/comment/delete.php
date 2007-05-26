<?php
$post = $comment->get_post();
if ($account->level < $board->perm_delete && $comment->user_id != $account->id) {
	access_denied();
}
if (is_post() && ($comment->user_id != 0 && $account->id == $comment->user_id || $account->level >= $board->perm_delete || $comment->user_id == 0 && $comment->password == md5($_POST['password']))) {
	if ($account->is_guest())
		$comment->deleted_by = $comment->name;
	else
		$comment->deleted_by = $account->name;
	$comment->delete();
	redirect_to(url_for($post));
} else {
	$link_cancel = url_for($post);

	if ($comment->user_id != 0 && $comment->user_id == $account->id ||
		$account->level >= $board->perm_delete) {
		$ask_password = false;
	} else {
		$ask_password = true;
	}
}
?>
