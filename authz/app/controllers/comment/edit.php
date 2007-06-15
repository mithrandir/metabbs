<?php
authz_require($account, 'edit', $comment);

$post = $comment->get_post();
if (is_post() && (!$account->is_guest() || $comment->password == md5($_POST['password']))) {
	$comment->body = $_POST['body'];
	$comment->update();
	redirect_to(url_for($post) . '#comment_' . $comment->id);
} else {
	$link_cancel = url_for($post);
	$ask_password = $account->is_guest() && $comment->user_id == 0;
	if (is_xhr()) {
		$style = $board->get_style();
		include "skins/$style->skin/edit_comment.php";
		exit;
	}
}
?>
