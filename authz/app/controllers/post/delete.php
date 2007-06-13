<?php
if ($account->level < $board->perm_delete && $post->user_id != $account->id) {
	access_denied();
}
if (is_post() && ($post->user_id != 0 && $account->id == $post->user_id || $account->level >= $board->perm_delete || $post->user_id == 0 && $post->password == md5($_POST['password']))) {
	apply_filters('PostDelete', $post);

	$attachments = $post->get_attachments();
	foreach ($attachments as $attachment) {
		@unlink($attachment->get_filename());
		if (file_exists('data/thumb/'.$attachment->id.'.png')) {
			@unlink('data/thumb/'.$attachment->id.'.png');
		}
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
}
?>
