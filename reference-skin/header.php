<?php
global $controller, $action;

if (isset($board))
	$admin = $account->has_perm('admin', $board);
$guest = $account->is_guest();
if ($guest) {
	$link_login = url_with_referer_for($board, 'login');
	$link_signup = url_with_referer_for('account', 'signup');
} else {
	$link_logout = url_with_referer_for('account', 'logout');
	$link_account = url_with_referer_for('account', 'edit');
	if ($account->is_admin()) {
		$link_admin = url_for('admin');
	} else {
		$link_admin = null;
	}
}

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
$manage_url = url_for($board, 'manage');

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
	foreach ($attachments as $k => $v) {
		$attachments[$k]->filename = shorten_path(htmlspecialchars($v->filename));
		$attachments[$k]->url = htmlspecialchars(url_for($v));
		$attachments[$k]->size = human_readable_size($v->get_size());
		if ($v->is_image()) {
			$attachments[$k]->thumbnail_url = url_for($v).'?thumbnail=1';
		} else {
			$attachments[$k]->thumbnail_url = null;
		}
	}
}
if (isset($comments)) {
	function flatten_comments($comments, $parent = 0, $depth = 0) {
		$_comments = array();
		foreach ($comments as $comment) {
			if ($comment->parent == $parent) {
				$comment->depth = $depth;
				$_comments[] = $comment;
				$children = flatten_comments($comments, $comment->id, $depth + 1);
				$_comments = array_merge($_comments, $children);
			}
		}
		return $_comments;
	}
	$comments = flatten_comments($comments);
}
if (isset($post) && $post->exists() && $account->has_perm('comment', $post)) {
	$comment_url = url_for($post, 'comment');
}
if ($controller == 'comment') {
	$comment_url = url_for($controller, $action);
	if ($action == 'edit') {
		$comment_author = $comment->name;
		$comment_body = $comment->body;
	}
}
if (isset($comment_url) && !isset($comment_author)) {
	$comment_author = $comment_body = "";
}
if (!isset($signature)) $signature = '';
?>
