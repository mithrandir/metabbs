<?php
if (is_post()) {
	if (!isset($_POST['post'])) {
		$_POST['post'] = @array(
			'title' => $_POST['title'],
			'category_id' => isset($_POST['category']) ? $_POST['category'] : 0,
			'notice' => isset($_POST['notice']) ? $_POST['notice'] : 0,
			'secret' => isset($_POST['secret']) ? $_POST['secret'] : 0,
			'body' => $_POST['body']
		);
		if (isset($_POST['author'])) {
			$_POST['post']['name'] = $_POST['author'];
			$_POST['post']['password'] = $_POST['password'];
		}
	}
	if (isset($_POST['post']['password'])) {
		$_POST['_auth_password'] = $_POST['post']['password'];
	}
	if (isset($_POST['trackback'])) {
		$_POST['trackback'] = @array(
			'to' => $_POST['trackback'],
			'title' => $_POST['post']['title'],
			'excerpt' => $_POST['post']['body'],
		    'url' => full_url_for($post),
			'blog_name' => $board->get_title()
		);
	}
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
	$template = get_template($board, 'write');
	$template->set('board', $board);
	$template->set('post', $post);
	$template->set('extra_attributes', $extra_attributes);
	$template->set('link_list', url_for($board));
	$template->set('link_cancel', url_for($post));
}
?>
