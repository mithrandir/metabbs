<?php
if ($account->id != $post->user_id && $account->level < $board->perm_delete) {
	access_denied();
}
if ($post->secret) {
	if ($post->user_id != $account->id && !$account->is_admin()) {
		access_denied();
	} else if ($post->user_id == 0 && $account->is_guest()) {
		if (is_post() && md5($_POST['password']) == $post->password) {
		} else {
			render('secret');
			return;
		}
	}
}
if (is_post() && !isset($_POST['password']) && ($post->user_id != 0 && $account->id == $post->user_id || $account->level >= $board->perm_delete || $post->user_id == 0 && md5($_POST['post']['password']) == $post->password)) {
	unset($_POST['post']['password']);
	$post->import($_POST['post']);
	$post->edited_at = time();
	$post->edited_by = $account->id;
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
