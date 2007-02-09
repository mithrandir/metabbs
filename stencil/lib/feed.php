<?php
if ($board->perm_read > $account->level) {
	exit;
}
if (isset($_GET['mode']) && $_GET['mode'] == 'css') {
	redirect_to(METABBS_BASE_PATH . "skins/$board->skin/feed.css");
}

/**
 * 피드의 해더를 꾸며준다.
 * @param $board 게시판 명
 * @param $format 가져올 포맷의 이름
 * @return 피드를 리턴한다.
 */
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
