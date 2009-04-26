<?
$board = Board::find_by_name($params['id']);
if($board->exists() && $board->get_attribute('feed-at-board')) {
	FeedParser::collect_feeds_to_board_by_random($board, 3600);
	echo "ok";
}
exit;
?>