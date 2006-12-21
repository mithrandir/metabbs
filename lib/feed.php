<?php
if ($board->perm_read > $account->level) {
	exit;
}
if (isset($_GET['mode']) && $_GET['mode'] == 'css') {
	redirect_to(METABBS_BASE_PATH . "skins/$board->skin/feed.css");
}
function feed_render_header($board, $format) {
	header("Content-Type: text/xml; charset=UTF-8");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$xslt = "skins/$board->skin/$format.xsl";
	if (file_exists($xslt)) {
		echo "<?xml-stylesheet type=\"text/xsl\" href=\"" . METABBS_BASE_PATH . $xslt . "\"?>\n";
	}
	$posts = $board->get_feed_posts($board->posts_per_page);
	apply_filters_array('PostViewRSS', $posts);
	return $posts;
}
?>
