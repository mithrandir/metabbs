<?php
if (!$account->has_perm('delete', $post))
	access_denied();

if (is_post()) {
	if (!$account->is_guest() || $post->password == md5($_POST['password'])) {
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
	}
}

$template = get_template($board, 'delete');
$template->set('board', $board);
$template->set('ask_password', $account->is_guest());
$template->set('link_cancel', url_for($post));
?>
