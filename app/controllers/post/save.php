<?php
if (!defined('SECURITY')) {
	return;
}
$limit = get_upload_size_limit();

// If the size of post data is greater than post_max_size, the $_POST and $_FILES superglobals are empty. (see http://php.net/manual/en/ini.core.php#ini.post-max-size)
if (empty($_POST) && empty($_FILES)) {
	print_notice('Max upload size exceeded', 'Please upload files smaller than ' . $limit . '.');
}

if (!$post->valid()) {
	// TODO: more friendly error message
	exit;
}

cookie_register('name', $post->name);

apply_filters('PostSave', $post);

if ($board->use_attachment && isset($_FILES['upload'])) {
	$uploads = $_FILES['upload'];
	$attachments = array();
	foreach ($uploads['name'] as $key => $filename) {
		if (!$filename) continue;
		if (!is_uploaded_file($uploads['tmp_name'][$key])) continue;
		if ($uploads['size'][$key] == 0) print_notice('Max upload size exceeded', 'Please upload files smaller than ' . $limit . '.');
		$attachments[] = new Attachment(array('filename' => $filename, 'tmp_name' => $uploads['tmp_name'][$key], 'type' => $uploads['type'][$key]));
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

if (isset($_POST['meta'])) {
	foreach ($_POST['meta'] as $k => $v) {
		$post->set_attribute($k, $v);
	}
}

redirect_to(url_for($post));
?>
