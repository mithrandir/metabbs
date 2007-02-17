<?php
$comment = new Comment($_POST['comment']);
if ($account->level < $board->perm_comment) {
	redirect_to(url_for($post));
}
if (!$comment->valid()) {
	exit;
}
$comment->user_id = $account->id;
if (!$account->is_guest()) {
	$comment->name = $account->name;
} else {
	cookie_register('name', $comment->name);
}

apply_filters('PostComment', $comment);

$post->add_comment($comment);
if (is_xhr()) {
	apply_filters('PostViewComment', $comment);
	include("skins/$board->skin/_comment.php");
	exit;
} else {
	redirect_to(url_for($post));
}
?>
