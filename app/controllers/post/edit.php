<?php
if (isset($_POST['post']['password'])) {
	$_POST['_auth_password'] = $_POST['post']['password'];
}
permission_required('edit', $post);

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
	$template = $board->get_style()->get_template('write');
	$template->set('board', $board);
	$template->set('post', $post);
	$template->set('extra_attributes', $extra_attributes);
	$template->set('link_list', url_for($board));
	$template->set('link_cancel', url_for($post));
}
?>
