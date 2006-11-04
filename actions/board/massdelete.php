<?php
if (is_post() && $account->level >= $board->perm_delete) {
	foreach ($_POST['delete'] as $post_id) {
		$post = Post::find($post_id);
		$attachments = $post->get_attachments();
		foreach ($attachments as $attachment) {
			@unlink($attachment->get_filename());
			$attachment->delete();
		}
		$post->delete();
	}
	redirect_to(url_for($board));
}

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
