<?php
if (is_post()) {
	if (isset($params['owner']) && is_numeric($params['owner'])) {
		$feed = Feed::find($params['owner']);
		$owner = User::find_by_user($params['value']);
		if ($owner->exists()) {
			$feed->remove_attribute('trackback-key');
			$feed->owner_id = $owner->id;
		} else {
			$feed->set_attribute('trackback-key', md5(microtime() . uniqid(rand(), true)));
			$feed->owner_id = 0;
		}
		$feed->update();
		Flash::set('주인을 변경했습니다');
		redirect_back();
	} else if (isset($params['owner-name']) && is_numeric($params['owner-name'])) {
		$feed = Feed::find($params['owner-name']);
		$feed->owner_name = $params['value'];
		$feed->update();
		Flash::set('주인이름을 변경했습니다');
		redirect_back();
	} else if (isset($params['delete']) && is_numeric($params['delete'])) {
		$feed = Feed::find($params['delete']);
		$feedboards = FeedBoard::find_all_by_feed($feed);

		foreach($feedboards as $feedboard)
			$feedboard->delete();
		// 관련된 feed_group 지움
		$feed->delete();
		Flash::set('피드를 삭제했습니다');
		redirect_back();
	} else {
		$userid = $params['userid'];
		$user = User::find_by_user($userid);
		$ownerid = isset($params['as_owner']) && $params['as_owner'] == 1 ? $user->id:null;
		if ($user->exists()) {
			if (FeedParser::relate_feed_by_user($params['feed_url'], $user, false, $ownerid)) {
				Flash::set('피드가 등록되었습니다');
			} else {
				Flash::set('피드가 등록되지 않았습니다');
			}
		} else
			$error_messages->add('없는 사용자 아이디입니다', 'userid');
		redirect_back();
	}

}

if (isset($params['active']) && is_numeric($params['active'])) {
	$feed = Feed::find($params['active']);
	$feed->active = !$feed->active;
//	$feed->hide_posts();
//	$feed->show_posts();
	$feed->update();
	Flash::set('수정했습니다');
	redirect_back();
}

$page = get_requested_page();
$feeds = Feed::find_all();
?>