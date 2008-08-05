<?php
if (!defined('SECURITY')) {
	return;
}

if (!$post->valid()) {
	header('HTTP/1.1 403 Forbidden');
	print_notice(i('Some fields are empty.'), i('Please fill out all fields.'));
	exit;
}

cookie_register('name', $post->name);

apply_filters('PostSave', $post);

if ($board->use_attachment && isset($_FILES['upload'])) {
	$uploads = $_FILES['upload'];
	$attachments = array();
	$limit = get_upload_size_limit();
	foreach ($uploads['name'] as $key => $filename) {
		if (!$filename) continue;
		if ($uploads['size'][$key] == 0 ||
			$uploads['error'][$key] == UPLOAD_ERR_INI_SIZE) {
			header('HTTP/1.1 413 Request Entity Too Large');
			print_notice(i('Max upload size exceeded'), i('Please upload files smaller than %s.', $limit));
		}
		if (!is_uploaded_file($uploads['tmp_name'][$key])) continue;
		$attachments[] = new Attachment(array('filename' => stripslashes($filename), 'tmp_name' => $uploads['tmp_name'][$key], 'type' => $uploads['type'][$key]));
	}
}

if ($post->exists()) {
	$post->update();
	apply_filters('AfterUpdatePost', $post);
} else {
	$board->add_post($post);
	apply_filters('AfterAddPost', $post);
}

if (isset($attachments)) {
	foreach ($attachments as $attachment) {
		$post->add_attachment($attachment);
		move_uploaded_file($attachment->tmp_name, 'data/uploads/' . $attachment->id);
		chmod('data/uploads/' . $attachment->id, 0606);
	}
}

if (isset($_POST['meta'])) {
	foreach ($_POST['meta'] as $k => $v) {
		$post->set_attribute($k, $v);
	}
}

if (isset($_POST['trackback']) && isset($_POST['trackback']['to'])
	&& ($_POST['trackback']['to'] != '')) {
	if (!isset($_POST['trackback']['url'])) {
		$_POST['trackback']['url'] = full_url_for($post);
	}
	send_trackback($_POST['trackback']);
}

redirect_to(url_for($post));
?>
