<?php
function modern_load_post_category(&$post) {
	$board = $post->get_board();
	if ($board->use_category) {
		if (!$post->category_id) {
			//$post->category = new UncategorizedPosts($board);
			$post->category = null;
		} else {
			$post->category = clone($post->get_category());
			$post->category->name = htmlspecialchars($post->category->name);
			$post->category->url = url_for($board, null, array('category' => $post->category->id));
		}
	} else {
		$post->category = null;
	}
}

function modern_load_tags(&$post) {
	$board = $post->get_board();
	if (!$board->use_tag()) return;
	$tags = $post->get_tags();
	if ($tags) {
		foreach ($tags as $k => $v) {
			$tags[$k]->name = htmlspecialchars($v->name);
			$tags[$k]->url = url_for($board, null, array('tag' => 1, 'keyword' => urlencode($v->name)));			
			$tags[$k]->last = false;
		}
		$tags[$k]->last = true;
	}
	$post->tags = &$tags;
}

function modern_common_filter(&$post) {
	$post->author = $post->name;
	$post->title = htmlspecialchars($post->title);
	modern_load_post_category($post);
}
function modern_list_filter(&$post) {
	modern_common_filter($post);
	$post->url = url_for($post, null, get_search_params());
	$post->date = date('Y-m-d', $post->created_at);
	$post->time = date('H:i:s', $post->created_at);
	if (isset($post->attachments)) {
		foreach ($post->attachments as $k => $v) {
			modern_attachment_filter($post->attachments[$k]);
		}
		$post->attachment_count = count($post->attachments);
	}
	modern_load_tags($post);
}
add_filter('PostList', 'modern_list_filter', 32768);

function modern_view_filter(&$post) {
	modern_common_filter($post);
	$board = $post->get_board();
	$post->url = url_for($post);
	$post->date = date('Y-m-d H:i:s', $post->created_at);
	if ($board->use_trackback) {
		$post->trackback_url = full_url_for($post, 'trackback');
	}
	$post->edited = $post->is_edited();
	if ($post->edited) {
		$editor = $post->get_editor();
		if (!$editor->is_guest()) $editor->name = htmlspecialchars($editor->name);
		$post->edited_by = $editor->name;
		$post->edited_at = date('Y-m-d H:i:s', $post->edited_at);
	}
}
add_filter('PostView', 'modern_view_filter', 32768);

function modern_comment_filter(&$comment) {
	global $account;
	$comment->author = $comment->name;
	$comment->date = date('Y-m-d H:i:s', $comment->created_at);
	if ($account->has_perm('reply', $comment)) {
		$comment->reply_url = url_for($comment, 'reply');
	} else {
		$comment->reply_url = null;
	}
	if ($account->has_perm('delete', $comment)) {
		$comment->delete_url = url_for($comment, 'delete');
	} else {
		$comment->delete_url = null;
	}
	if ($account->has_perm('edit', $comment)) {
		$comment->edit_url = url_for($comment, 'edit');
	} else {
		$comment->edit_url = null;
	}
}
add_filter('PostViewComment', 'modern_comment_filter', 32768);

function modern_attachment_filter(&$attachment) {
	$attachment->filename = shorten_path(htmlspecialchars($attachment->filename));
	$attachment->url = htmlspecialchars(url_for($attachment));
	$attachment->size = human_readable_size($attachment->get_size());
	if ($attachment->is_image()) {
		$attachment->thumbnail_url = url_for($attachment, null, array('thumb' => 1));
	} else {
		$attachment->thumbnail_url = null;
	}
}
?>
