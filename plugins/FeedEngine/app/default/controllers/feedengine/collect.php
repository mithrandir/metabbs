<?php
login_required();
$feed = Feed::find($params['id']);
if ($feed->exists()){
	$feed_user = FeedUser::find_by_user_and_feed($account, $feed);
	if($feed->is_active() && $feed_user->exists()) {
		$boards = Board::find_all();
		foreach ($boards as $board) {
			if ($board->get_attribute('feed-at-board')) {
				FeedParser::collect_feed_to_board($feed, $board);
			}
		}
		Flash::set('피드를 수집했습니다');
	} else {
		Flash::set('피드를 수집할 수 없습니다');
	}
}
if(is_xhr()) {
	include 'themes/'.get_current_theme().'/_homepage.php';exit;
} else
	redirect_back();	
?>