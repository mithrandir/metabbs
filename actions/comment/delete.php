<?php
$post = $comment->get_post();
if (is_post() && ($user->level >= $board->perm_delete ||
		$comment->password == md5($_POST['password']))) {
	$comment->delete();
	redirect_to(url_for($post));
} else {
	$nav[] = link_to(i("Cancel"), $post);

	if ($comment->user_id != 0 && $comment->user_id == $user->id ||
		$user->level >= $board->perm_delete) {
		$ask_password = false;
	} else {
		$ask_password = true;
	}
	render('delete');
}
?>
