<?php
$post = $comment->get_post();
if ($account->level < $board->perm_delete && $comment->user_id != $account->id) {
	access_denied();
}
if (is_post() && ($comment->user_id != 0 && $account->id == $comment->user_id || $account->level >= $board->perm_delete || $comment->user_id == 0 && $comment->password == md5($_POST['password']))) {
	$comment->body = $_POST['body'];
	$comment->update();
	redirect_to(url_for($post) . '#comment_' . $comment->id);
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
