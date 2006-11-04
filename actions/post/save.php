<?php
if (!defined('SECURITY')) {
	return;
}
if (!$account->is_guest()) {
	$post->user_id = $account->id;
	$post->name = $account->name;
} else {
	cookie_register('name', $post->name);
}

apply_filters('PostSave', $post);

if ($board->use_attachment && isset($_FILES['upload'])) {
	$uploads = $_FILES['upload'];
	$attachments = array();
	foreach ($uploads['name'] as $key => $filename) {
		if (!$filename) continue;
		if ($uploads['size'][$key] == 0) print_notice('Max upload size exceeded', 'Please upload files smaller than ' . ini_get('upload_max_filesize') . '.');
		$attachments[] = new Attachment(array('filename' => $filename, 'tmp_name' => $uploads['tmp_name'][$key]));
	}
}

if ($post->exists()) {
	$post->update();
} else {
	$board->add_post($post);
}

if (isset($attachments)) {
	foreach ($attachments as $attachment) {
		$post->add_attachment($attachment);
		move_uploaded_file($attachment->tmp_name, 'data/uploads/' . $attachment->id);
	}
}

redirect_to(url_for($post));

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
