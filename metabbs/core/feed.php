<?php
function render_feed($title, $url, $description, $posts, $format) {
	foreach($posts as $post)
		$post->permalink = full_url_for($post);
	apply_filters_array('PostViewRSS', $posts);
	feed_header();
	include "app/default/views/feed/$format.php";
}

function feed_header() {
	header("Content-Type: text/xml; charset=UTF-8");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
}

function render_board_feed($board, $format) {
	requireCore('cache');
	$cache = new PageCache;
	$cache->name = "feed_{$format}_{$board->name}";
	if($cache->load()) { //If successful loads
		return $cache->contents;
	}
	ob_start();
	$title = $board->get_title();
	render_feed($title, full_url_for($board), "The latest posts from $title",
			$board->get_feed_posts($board->posts_per_page), $format);
	$ob = ob_get_contents();
	ob_end_clean();
	$cache->contents = $ob;
	$cache->update();
	unset($cache);
	return $ob;
}

function array_trim($var) {
    if (is_array($var))
        return array_map("array_trim", $var);
    if (is_string($var))
        return trim($var);
    return $var;
}
