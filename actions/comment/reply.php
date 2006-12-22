<?php
if ($account->level < $board->perm_comment) {
	access_denied();
}
if (is_post()) {
	$_comment = new Comment($_POST['comment']);
	$_comment->user_id = $account->id;
	$_comment->parent = $comment->id;
	if (!$account->is_guest()) {
		$_comment->name = $account->name;
	} else {
		cookie_register('name', $_comment->name);
	}

	apply_filters('PostComment', $comment);

	$post = $comment->get_post();
	$post->add_comment($_comment);
	redirect_to(url_for($post));
} else {
	$name = cookie_get('name');
	render('reply');
}
?>
