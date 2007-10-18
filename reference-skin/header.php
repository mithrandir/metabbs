<?php
global $controller, $action;

$admin = $account->has_perm('admin', $board);

// for write.php
if ($controller == 'post' && $action == 'edit' ||
	$controller == 'board' && $action == 'post') {
	$categories = $board->get_categories();
	$notice_checked = $post->notice ? 'checked="checked"' : '';
	$secret_checked = $post->secret ? 'checked="checked"' : '';
	$editing = $action == 'edit';
	$post->author = $post->name;
	$additional_fields = array();
	foreach ($extra_attributes as $attr) {
		$attr->name = htmlspecialchars($attr->name);
		$attr->output = $attr->render($post->get_attribute($attr->key));
		$additional_fields[] = $attr;
	}
	if ($post->exists()) {
		$attachments = $post->get_attachments();
	} else {
		$attachments = array();
	}
	$uploadable = $board->use_attachment;
	$upload_limit = get_upload_size_limit();
}

// for list.php
if (isset($categories)) {
	foreach ($categories as $k => $c) {
		if (isset($post) && $post->category_id == $c->id) {
			$categories[$k]->selected = 'selected="selected"';
		} else {
			$categories[$k]->selected = '';
		}
		$categories[$k]->url = url_for($board, '', array('category' => $c->id));
		$categories[$k]->post_count = $c->get_post_count();
	}
} else {
	$categories = null;
}

// for view.php
if (isset($post) && !$board->use_trackback) {
	$post->trackback_url = null;
	$trackbacks = array();
}
if (isset($newer_post)) {
	if (!$newer_post->exists()) {
		$newer_post = null;
	} else {
		$newer_post->url = url_for($newer_post);
		$newer_post->title = htmlspecialchars($newer_post->title);
	}
}
if (isset($older_post)) {
	if (!$older_post->exists()) {
		$older_post = null;
	} else {
		$older_post->url = url_for($older_post);
		$older_post->title = htmlspecialchars($older_post->title);
	}
}
if (isset($attachments)) {
	if (!$board->use_attachment) {
		$attachments = array();
	} else foreach ($attachments as $k => $v) {
		$attachments[$k]->filename = shorten_path(htmlspecialchars($v->filename));
		$attachments[$k]->url = htmlspecialchars(url_for($v));
		$attachments[$k]->size = human_readable_size($v->get_size());
	}
}
if (isset($post) && $post->exists() && $account->has_perm('comment', $post)) {
	$comment_url = url_for($post, 'comment');
}
$guest = $account->is_guest();
if (!isset($signature)) $signature = '';
?>
