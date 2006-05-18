<?php
$post = $comment->get_post();
if (is_post() && ($user->level >= $board->perm_delete ||
		$comment->password == md5($_POST['password']))) {
	$comment->delete();
	redirect_to(url_for($post));
}
else if ($comment->user_id != 0 && $comment->user_id == $user->id ||
		$user->level >= $board->perm_delete) {
	render('admindelete');
}
else if ($comment->user_id == 0) {
	render('delete');
}
?>
