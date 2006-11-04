<?php
if ($board->perm_write > $account->level) {
	access_denied();
}
if (is_post()) {
	$post = new Post($_POST['post']);
	define('SECURITY', 1);
	include 'actions/post/save.php';
} else {
	$post = new Post;
	$post->name = cookie_get('name');
	$link_list = url_for($board);
	$link_cancel = null;
	render('write');
}

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
