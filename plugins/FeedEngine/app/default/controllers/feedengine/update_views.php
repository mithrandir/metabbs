<?php
$board = Board::find_by_name($params['id']);
$post = Post::find($params['post']);
if($board->exists() && $post->exists() && $board->get_attribute('feed-at-board')) {
	// backward compatibility; #156
	if (cookie_is_registered('seen_posts')) {
		$seen_posts = explode(',', cookie_get('seen_posts'));
		$_SESSION['seen_posts'] = $seen_posts;
		cookie_unregister('seen_posts');
	}

	if (!session_is_registered('seen_posts')) {
		$_SESSION['seen_posts'] = array();
	}
	
	if (!in_array($post->id, $_SESSION['seen_posts'])) {
		$post->update_view_count();
		$_SESSION['seen_posts'][] = $post->id;
	}
}
exit;
?>