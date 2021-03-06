<?php
login_required();
$feed = Feed::find($params['id']);
if ($feed->exists()) {
	$feed_user = FeedUser::find_by_user_and_feed($account, $feed);
	if ($feed_user->exists()) {			
		$feed_user->remove_attribute('trackback-key');
		$feed_user->remove_attribute('owner-id');
		Flash::set('트랙백 인증키가 삭제되었습니다');
	}
}
if(is_xhr()) {
	include 'themes/'.get_current_theme().'/_homepage.php';
	exit;
} else
	redirect_back();
?>