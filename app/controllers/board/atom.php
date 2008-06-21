<?php
require_once 'lib/feed.php';

permission_required('list', $board);

$title = $board->get_title();
feed_render($title, full_url_for($board), "The latest posts from $title",
		$board->get_feed_posts($board->posts_per_page), 'atom');
