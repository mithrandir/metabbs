<?php
permission_required('write', $board);

if (is_post()) {
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
			'body' => $_POST['body']
		);
	}

	$post = new Post(@$_POST['post']);
	if (!$account->is_guest()) {
		$post->user_id = $account->id;
		$post->name = $account->name;
	}
	define('SECURITY', 1);
	include 'app/controllers/post/save.php';
} else {
	$post = new Post;
	$post->name = cookie_get('name');
	if (isset($_GET['search'])) {
		$post->category_id = $_GET['search']['category'];
	}

	$template = get_template($board, 'write');
	$template->set('board', $board);
	$template->set('post', $post);
	$template->set('extra_attributes', $extra_attributes);
	$template->set('link_list', url_for($board));
	$template->set('link_cancel', '');
}
?>
