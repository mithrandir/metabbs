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
		TrashCan::put($comment, 'deleted by ' . $comment->deleted_by);

		if (is_xhr()) {
			$template = get_template($board, '_comment');
			apply_filters('PostViewComment', $comment);
			$template->set('board', $board);
			$template->set('comment', $comment);
			$template->render_partial();
			exit;
		} else {
			redirect_to(url_for($post));
		}
	}
}

$template = get_template($board, 'delete');
$template->set('board', $board);
$template->set('comment', $comment);
$template->set('ask_password', $account->is_guest());
$template->set('link_cancel', url_for($post));

if (is_xhr()) {
	$template->render_partial();
	exit;
}
?>
