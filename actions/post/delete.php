<?php
if (is_post() && ($user->level >= $board->perm_delete ||
		$post->password == md5($_POST['password']))) {
	$post->delete();
	redirect_to(url_for($board));
} else {
	$nav[] = link_to(i("Cancel"), $post);

	if ($post->user_id != 0 && $post->user_id == $user->id ||
		$user->level >= $board->perm_delete) {
		$ask_password = false;
	} else if ($post->user_id == 0) {
		$ask_password = true;
	}
	render('delete');
}
?>
