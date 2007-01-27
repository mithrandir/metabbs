<?php
if ($account->id != $post->user_id && $account->level < $board->perm_delete) {
	access_denied();
}
if (is_post()) {
	if ($post->user_id == 0 && $board->perm_delete > $account->level) {
		if ($post->password != md5($_POST['post']['password'])) {
			redirect_to(url_for($post, 'edit'));
		}
	}

	unset($_POST['post']['password']);
	$post->import($_POST['post']);
	if ($board->use_attachment && isset($_POST['delete'])) {
		foreach ($_POST['delete'] as $id) {
			$attachment = Attachment::find($id);
			$attachment->delete();
			@unlink('data/uploads/'.$id);
		}
	}
	define('SECURITY', 1);
	include 'actions/post/save.php';
} else {
	$link_list = url_for($board);
	$link_cancel = url_for($post);
	
	render('write');
}
?>
