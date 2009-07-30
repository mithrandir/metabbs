<?php
$post = Post::find($params['id']);
$board = $post->get_board();

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
if (!is_xhr()) {
	redirect_back();
}
exit;
?>