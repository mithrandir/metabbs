<?php
if (is_post()) {
	check_post_max_size_overflow();

	if (!isset($_POST['post'])) {
		$_POST['post'] = @array(
			'title' => $_POST['title'],
			'category_id' => isset($_POST['category']) ? $_POST['category'] : 0,
			//'notice' => isset($_POST['notice']) ? $_POST['notice'] : 0,
			'secret' => isset($_POST['secret']) ? $_POST['secret'] : 0,
			'body' => $_POST['body'],
			'tags' => $_POST['tags']
		);
		$_POST['post']['notice'] = isset($_POST['notice']);
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

if (is_post()) {
	$post_password = $_POST['post']['password'];
	unset($_POST['post']['password']);
	$post->import($_POST['post']);
	$post->edited_at = time();
	$post->edited_by = $account->id;

	apply_filters('ValidatePostModify', $_POST, $error_messages);

	if (empty($post->name))
		$error_messages->add('Please enter the name', 'author');

	if (empty($post->title))
		$error_messages->add('Please enter the title', 'title');

	if (empty($post->body))
		$error_messages->add('Please enter the body', 'body');

	if ($account->is_guest() && strlen($post->password) < 5)
		$error_messages->add('Password length must be longer than 5', 'password');

	if ($account->is_guest() && $post->password != md5($post_password))
		$error_messages->add('Password fields\' content is not matched', 'password');

	if(!$error_messages->exists()) {	
		if ($_POST['action'] == 'preview') {
			$preview = clone($post);
			apply_filters('PostSave', $preview);
			apply_filters('PostView', $preview);
		} else {
			if ($board->use_attachment && isset($_POST['delete'])) {
				foreach ($_POST['delete'] as $id) {
					$attachment = Attachment::find($id);
					$attachment->delete();
					@unlink('data/uploads/'.$id);
				}
			}

			define('SECURITY', 1);
			include 'app/default/controllers/board/save.php';
		}
	}
}
