<?php
permission_required('edit', $comment);

$post = $comment->get_post();
if (is_post() && (!$account->is_guest() || $comment->password == md5($_POST['password']))) {
	$comment->body = $_POST['body'];
	$comment->update();
	redirect_to(url_for($post) . '#comment_' . $comment->id);
} else {
	$template = get_template($board, 'edit_comment');
	$template->set('comment', $comment);
	$template->set('ask_password', $account->is_guest());
	$template->set('link_cancel', url_for($post));

	if (is_xhr()) {
		$template->render();
		exit;
	}
}
?>
