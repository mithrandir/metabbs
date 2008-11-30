<?php
if (is_post()) {
	check_post_max_size_overflow();

	if (!isset($_POST['post'])) {
		$_POST['post'] = @array(
			'title' => $_POST['title'],
			'category_id' => isset($_POST['category']) ? $_POST['category'] : 0,
			'notice' => isset($_POST['notice']) ? $_POST['notice'] : 0,
			'secret' => isset($_POST['secret']) ? $_POST['secret'] : 0,
			'body' => $_POST['body'],
			'tags' => $_POST['tags']
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
		    'url' => full_url_for_metabbs('post', 'index', array('id'=>$post->id, 'board-name'=>$board->name)),
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
	if ($_POST['action'] == 'preview') {
		if (version_compare(phpversion(), '5.0.0', '<')) {
			$preview = $post;
		} else {
			eval('$preview = clone $post;');
		}

		apply_filters('PostSave', $preview);
		apply_filters('PostView', $preview);
	} else {
		define('SECURITY', 1);
		include 'containers/metabbs/controllers/post/save.php';
	}
}
