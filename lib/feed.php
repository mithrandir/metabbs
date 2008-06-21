<?php
function feed_render($title, $url, $description, $posts, $format) {
	apply_filters_array('PostViewRSS', $posts);
	header("Content-Type: text/xml; charset=UTF-8");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	include "app/views/feed/$format.php";
	exit;
}
