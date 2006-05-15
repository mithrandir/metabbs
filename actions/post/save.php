<?php
if (!isset($post)) {
    $post = new Post($params['post']);
    $post->board_id = $board->id;
} else {
    if ($post->password != md5($params['post']['password'])) {
        redirect_to($post->get_href() . '/edit');
    }
    $post->import($params['post']);
    if ($params['delete']) {
        foreach ($params['delete'] as $id) {
            $attachment = Attachment::find($id);
            $attachment->delete();
            @unlink('data/uploads/'.$id);
        }
    }
}
$_SESSION['name'] = $post->name;
$post->save();
if (isset($_FILES['upload'])) {
    foreach ($_FILES['upload']['name'] as $key => $filename) {
        if (!$filename) {
            continue;
        }
        if ($_FILES['upload']['size'][$key] == 0) {
        	continue;
		}
        $attachment = new Attachment();
        $attachment->post_id = $post->id;
        $attachment->filename = $filename;
        $attachment->save();
        move_uploaded_file($_FILES['upload']['tmp_name'][$key], 'data/uploads/' . $attachment->id);
    }
}
redirect_to($post->get_href());
?>
