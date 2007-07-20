<?php
permission_required('delete', $post);

if (is_post()) {
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
	$template = $board->get_style()->get_template('delete');
	$template->set('ask_password', false);
	$template->set('link_cancel', url_for($post));
}
?>
