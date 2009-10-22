<?php
if (!$account->has_perm('delete', $post))
	access_denied();

$_post_deleted = false;
if (is_post()) {
	apply_filters('BeforePostDelete', $post);
	if ($account->is_guest()) {
		if ($post->password != md5($params['password']))
			$error_messages->add('The Password does not matched', 'password');
	} else {
		if ($post->user_id != $account->id) {
			Flash::set('Invalid Owner');
		}
	}

	if (!$error_messages->exists()) {
		$attachments = $post->get_attachments();
		foreach ($attachments as $attachment) {
			@unlink($attachment->get_filepath(true));
			if (file_exists(METABBS_DIR . '/data/thumb/'.$attachment->id.'.png')) {
				@unlink(METABBS_DIR . '/data/thumb/'.$attachment->id.'.png');
			}
			$attachment->delete();
		}
		$post->delete();
		$_post_deleted = true;
		apply_filters('AfterPostDelete', $post);

		redirect_to(url_for($board, null, get_search_params()));
	}
}
