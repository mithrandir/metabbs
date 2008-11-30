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

		$params = null;
		apply_filters('BeforeRedirectAtDeletePost', $params, $board);
//		redirect_to(url_for($board, '', $params));
		$_params = array();
		$_params['id'] = $post->id;
		$_params['board-name'] = $board->name;
		redirect_to(url_for_metabbs('board', 'index', $_params));
	}
}
