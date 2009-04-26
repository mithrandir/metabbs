<?php
if (isset($params['feed-at-board']) && !empty($params['feed-at-board'])) {
	$board = Board::find_by_name($params['feed-at-board']);
	$board->set_attribute('feed-at-board', $board->get_attribute('feed-at-board') ? false : true);
	redirect_back();
}
if (isset($params['feed-range']) && !empty($params['feed-range'])) {
	$board = Board::find_by_name($params['feed-range']);
	$feed_range = $board->get_attribute('feed-range');
	$feed_range ++;
	if ($feed_range > 3) $feed_range = 0;

	$board->set_attribute('feed-range', $feed_range);
	redirect_back();
}

if (isset($params['collect-feed']) && !empty($params['collect-feed'])) {
	// purge feed cache
	$files = scandir(METABBS_DIR . '/data/feed_cache');
	foreach($files as $file) {
		if ($file == '.' || $file == '..') continue;
		@unlink(METABBS_DIR . '/data/feed_cache/' . $file);
	}

	$board = Board::find_by_name($params['collect-feed']);
	FeedParser::collect_feeds_to_board($board);
	Flash::set('피드수집 완료 했습니다');
	redirect_back();
}
if (isset($params['feed-kind']) && !empty($params['feed-kind'])) {
	$board = Board::find_by_name($params['feed-kind']);
	$feed_kind = $board->get_attribute('feed-kind');
	$feed_kind ++;
	if ($feed_kind > 2) $feed_kind = 0;

	$board->set_attribute('feed-kind', $feed_kind);
	redirect_back();
}
if (isset($params['feed-tags']) && !empty($params['feed-tags'])) {
	$board = Board::find_by_name($params['feed-tags']);
	$tags = array_trim(explode(",",$_POST['value']));
	$board->set_attribute('tags', implode(',', $tags));
	Flash::set('수정했습니다');
	redirect_back();
}

$boards = Board::find_all();
?>