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
?>
