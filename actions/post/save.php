<?php
if (!defined('SECURITY')) {
	return;
}
if (!$user->is_guest()) {
	$post->user_id = $user->id;
	$post->name = $user->name;
} else {
	cookie_register('name', $post->name);
}
$post->save();
if (isset($_FILES['upload'])) {
	$upload = $_FILES['upload'];
	if (!file_exists('data/uploads')) {
		@mkdir('data/uploads', 0777);
	}
	foreach ($upload['name'] as $key => $filename) {
		if (!$filename || $upload['size'][$key] == 0) {
			continue;
		}
		$attachment = new Attachment;
		$attachment->post_id = $post->id;
		$attachment->filename = $filename;
		$attachment->save();
		move_uploaded_file($upload['tmp_name'][$key], 'data/uploads/' . $attachment->id);
	}
}
redirect_to(url_for($post));
?>
