<?php
permission_required('write', $board);

$captcha = $config->get('captcha_name', false) != "none" && $board->use_captcha() && $guest 
	? new Captcha($config->get('captcha_name', false), $captcha_arg) : null;

if (is_post()) {
	check_post_max_size_overflow();

	if (!$account->has_perm('admin', $board)) {
		unset($_POST['post']['notice']);
	}
	
	if (!isset($_POST['post'])) {
		$_POST['post'] = array(
			'name' => $_POST['author'],
			'password' => $_POST['password'],
			'title' => $_POST['title'],
			'category_id' => isset($_POST['category']) ? $_POST['category'] : 0,
			'notice' => isset($_POST['notice']) ? $_POST['notice'] : 0,
			'secret' => isset($_POST['secret']) ? $_POST['secret'] : 0,
			'body' => $_POST['body'],
			'tags' => $_POST['tags']
		);
	}

	if (isset($_POST['trackback'])) {
		$_POST['trackback'] = @array(
			'to' => $_POST['trackback'],
			'title' => $_POST['post']['title'],
			'excerpt' => $_POST['post']['body'],
			'blog_name' => $title
		);
	}

	$post = new Post(@$_POST['post']);
	if (!$account->is_guest()) {
		$post->user_id = $account->id;
		$post->name = $account->name;
	}

	if (isset($captcha) && $captcha->ready() && $captcha->is_valid($_POST) 
		|| isset($captcha) && !$captcha->ready() 
		|| !isset($captcha)) {
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
			include 'app/controllers/post/save.php';
		}
	}
} else {
	$post = new Post;
	$post->name = cookie_get('name');
	if (isset($_GET['search'])) {
		$post->category_id = $_GET['search']['category'];
	}
}
