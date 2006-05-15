<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($post->password != md5($params['password'])) {
        break;
    }
    $attachments = $post->get_attachments();
    foreach ($attachments as $attachment) {
        @unlink('data/uploads/'.$attachment->id);
    }
    $post->delete();
	redirect_to($board->get_href());
}
?>