<?php
requireCore('feed');
requireCore('cache');
$cache = new PageCache;
$cache->name = "feed_all_comments";
if($cache->load()) { //If successful loads
	echo $cache->contents;
} else {
	ob_start();
	$title = 'Full site feed (comments)';
	$url = full_url_for('feed', 'comments');
	$comments = Site::get_latest_comments(20);
	apply_filters_array('CommentViewFeed', $comments);

	feed_header();
	include 'app/default/views/feed/comments.php';
	$ob = ob_get_contents();
	ob_end_clean();
	$cache->contents = $ob;
	$cache->update();
	unset($cache);
}
exit;
