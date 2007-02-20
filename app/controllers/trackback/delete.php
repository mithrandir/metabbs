<?php
$trackback = Trackback::find($id);
$post = $trackback->get_post();
$board = $post->get_board();
if ($account->level < $board->perm_delete) {
	access_denied();
}
$trackback->delete();
redirect_to(url_for($post));
?>
