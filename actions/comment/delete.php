<?php
$post = $comment->get_post();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($comment->password == md5($params['password'])) {
        $comment->delete();
		redirect_to($post->get_href());
    }
}
?>
