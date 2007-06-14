<?php
authz_require($account, 'edit', $post);

if (is_post() && isset($_POST['post']) && (!$account->is_guest() || $post->password == md5($_POST['post']['password']))) {
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
	include 'app/controllers/post/save.php';
} else {
	$link_list = url_for($board);
	$link_cancel = url_for($post);
}
?>
