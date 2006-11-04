<?php
if (is_post() && ($account->level >= $board->perm_delete ||
		$post->password == md5($_POST['password']))) {
	$attachments = $post->get_attachments();
	foreach ($attachments as $attachment) {
		@unlink($attachment->get_filename());
		$attachment->delete();
	}
	$post->delete();
	redirect_to(url_for($board));
} else {
	$link_cancel = url_for($post);

	if ($post->user_id != 0 && $post->user_id == $account->id ||
		$account->level >= $board->perm_delete) {
		$ask_password = false;
	} else if ($post->user_id == 0) {
		$ask_password = true;
	}
	render('delete');
}

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
