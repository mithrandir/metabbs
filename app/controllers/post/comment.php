<?php
permission_required('comment', $post);

$comment = new Comment($_POST['comment']);
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
	$template = $board->get_style()->get_template('_comment');
	$template->set('board', $board);
	$template->set('comment', $comment);
	$template->render();
	exit;
} else {
	redirect_to(url_for($post));
}
?>
