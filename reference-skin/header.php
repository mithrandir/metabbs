<?php
// for list.php
if (isset($categories)) {
	foreach ($categories as $k => $c) {
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
if (isset($post) && $account->has_perm('comment', $post)) {
	$comment_url = url_for($post, 'comment');
	$guest = $account->is_guest();
}
if (!isset($signature)) $signature = '';
?>
