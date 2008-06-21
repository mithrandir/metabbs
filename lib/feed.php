<?php
function render_feed($title, $url, $description, $posts, $format) {
	apply_filters_array('PostViewRSS', $posts);
	header("Content-Type: text/xml; charset=UTF-8");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	include "app/views/feed/$format.php";
	exit;
}

function render_board_feed($board, $format) {
	$title = $board->get_title();
	render_feed($title, full_url_for($board), "The latest posts from $title",
			$board->get_feed_posts($board->posts_per_page), $format);
}
