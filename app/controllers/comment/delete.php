<?php
permission_required('delete', $comment);

$post = $comment->get_post();
if (is_post()) {
	if ($account->is_guest())
		$comment->deleted_by = $comment->name;
	else
		$comment->deleted_by = $account->name;
	$comment->delete();
	redirect_to(url_for($post));
} else {
	$template = $board->get_style()->get_template('delete');
	$template->set('ask_password', false);
	$template->set('link_cancel', url_for($post));
}
?>
