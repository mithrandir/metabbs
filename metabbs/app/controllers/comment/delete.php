<?php
if (!$account->has_perm('delete', $comment))
	access_denied();

$post = $comment->get_post();
if (is_post()) {
	if (!$account->is_guest() || $comment->password == md5($_POST['password'])) {
		if ($account->is_guest())
			$comment->deleted_by = $comment->name;
		else
			$comment->deleted_by = $account->name;
		$comment->delete();
		redirect_to(url_for($post));
	}
}

$template = get_template($board, 'delete');
$template->set('board', $board);
$template->set('ask_password', $account->is_guest());
$template->set('link_cancel', url_for($post));
?>
