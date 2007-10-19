<?php
$template_engine = 'default';
$options = array('get_body_in_the_list' => false, 'build_comment_tree' => false);

/*
TODO:
	category->name : category->url vs category : category_url
	깊이가 많이 들어가면 헷갈릴 듯.
*/

if (!defined('MODERN_SKIN')) {
	define('MODERN_SKIN', 1);

	function modern_common_filter(&$post) {
		$post->author = $post->name;
		$post->title = htmlspecialchars($post->title);
		$board = $post->get_board();
		if ($board->use_category) {
			if (!$post->category_id) {
				$post->category = new UncategorizedPosts($board);
			} else {
				$post->category = $post->get_category();
			}
			$post->category->name = htmlspecialchars($post->category->name);
			$post->category->url = url_for($board, '', array('category' => $post->category->id));
		} else {
			$post->category = null;
		}
	}
	function modern_list_filter(&$post) {
		modern_common_filter($post);
		$post->url = url_for($post, '', get_search_params());
		$post->date = date('Y-m-d', $post->created_at);
	}
	add_filter('PostList', 'modern_list_filter', 32768);

	function modern_view_filter(&$post) {
		modern_common_filter($post);
		$post->date = date('Y-m-d H:i:s', $post->created_at);
		$post->trackback_url = full_url_for($post, 'trackback');
		$post->edited = $post->is_edited();
		if ($post->edited) {
			$editor = $post->get_editor();
			$post->edited_by = htmlspecialchars($editor->name);
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
}
?>
