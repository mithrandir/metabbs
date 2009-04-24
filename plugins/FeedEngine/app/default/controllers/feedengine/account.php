<?php
login_required();

switch($id) {
	case 'add':
		$msg = FeedParser::relate_feed_by_user($_POST['feed_url'], $account) ? '피드가 등록되었습니다.' : '피드가 등록되지 않았습니다.';

		break;
	case 'remove':
		$feed = Feed::find($_GET['feed_id']);
		if ($feed->exists()) {
			$feed_user = FeedUser::find_by_user_and_feed($account, $feed);
			if ($feed_user->exists()){
				$feed_user->remove_attribute('trackback-key');
				$feed_user->remove_attribute('owner-id');
			}
			if($feed->owner_id == $account->id) {
				$feed->delete();
			}
			else
				$feed->unrelate_to_user($account);
		}
		$msg = '피드가 삭제되었습니다.';

		break;
	case 'set_default':
		$feed = Feed::find($_GET['feed_id']);
		if($feed->exists()){
			$account->url = $feed->link;
			$account->update();
		}
		break;
	case 'unset_default':
		$account->url = '';
		$account->update();
		break;
	case 'collect_feed':
		$feed = Feed::find($_GET['feed_id']);
		if ($feed->exists()){
			$feed_user = FeedUser::find_by_user_and_feed($account, $feed);
			if($feed->is_active() && $feed_user->exists()) {
				$boards = Board::find_all();
				foreach ($boards as $board) {
					if ($board->get_attribute('feed-at-board')) {
						FeedParser::collect_feed_to_board($feed, $board);
					}
				}
				$msg = '피드를 수집했습니다.';
			} else {
				$msg = '피드를 수집 할 수 없습니다.';
			}
		}
		break;
	case 'set_trackback_key':
		$feed = Feed::find($_GET['feed_id']);
		if ($feed->exists()) {
			$feed_user = FeedUser::find_by_user_and_feed($account, $feed);
			if ($feed_user->exists()) {
				$feed_user->set_attribute('trackback-key', md5(microtime() . uniqid(rand(), true)));
				$feed_user->set_attribute('owner-id',$user->id);
				$msg = '트랙백 인증키가 발급되었습니다.';
			}
		}
		break;
	case 'unset_trackback_key':
		$feed = Feed::find($_GET['feed_id']);
		if ($feed->exists()) {
			$feed_user = FeedUser::find_by_user_and_feed($account, $feed);
			if ($feed_user->exists()) {			
				$feed_user->remove_attribute('trackback-key');
				$feed_user->remove_attribute('owner-id');
				$msg = '트랙백 인증키가 삭제되었습니다.';
			}
		}
		break;

}

if(is_xhr()) {
	include 'themes/'.get_current_theme().'/_homepage.php';
} else
	if($_GET['url'])
		redirect_to($_GET['url']);
exit;
?>