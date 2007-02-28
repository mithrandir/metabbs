<?php
if ($account->level < $board->perm_comment) {
	access_denied();
}
if (is_post()) {
	$_comment = new Comment($_POST['comment']);
	$_comment->user_id = $account->id;
	$_comment->parent = $comment->id;
	if (!$_comment->valid()) {
		exit;
	}
	if (!$account->is_guest()) {
		$_comment->name = $account->name;
	} else {
		cookie_register('name', $_comment->name);
	}

	apply_filters('PostComment', $_comment);

	$post = $comment->get_post();
	$post->add_comment($_comment);

	if (is_xhr()) {
		$comment = $_comment;
		apply_filters('PostViewComment', $comment);
		$style = $board->get_style();
		include "skins/$style->skin/_comment.php";
		exit;
	} else {
		redirect_to(url_for($post));
	}
} else {
	$name = cookie_get('name');
	if (is_xhr()) {
		$style = $board->get_style();
		include "skins/$style->skin/reply.php";
		exit;
	}
}
?>
