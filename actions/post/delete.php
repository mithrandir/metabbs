<?php
if (is_post() && ($user->level >= $board->perm_delete ||
		$post->password == md5($_POST['password']))) {
	$post->delete();
	redirect_to(url_for($board));
} else if ($post->user_id != 0 && $post->user_id == $user->id ||
		$user->level >= $board->perm_delete) {
	render('admindelete');
} else if ($post->user_id == 0) {
	render('delete');
}
?>
