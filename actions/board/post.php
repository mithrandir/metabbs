<?php
if ($board->perm_write > $account->level) {
	access_denied();
}
if (is_post()) {
	$post = new Post(@$_POST['post']);
	define('SECURITY', 1);
	include 'actions/post/save.php';
} else {
	$post = new Post;
	$post->name = cookie_get('name');
	if (isset($_GET['search'])) {
		$post->category_id = $_GET['search']['category'];
	}
	$link_list = url_for($board);
	$link_cancel = null;
	render('write');
}
?>
