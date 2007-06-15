<?php
$trackback = Trackback::find($id);
$post = $trackback->get_post();
$board = $post->get_board();

authz_require($account, 'admin', $board);

$trackback->delete();
redirect_to(url_for($post));
?>
