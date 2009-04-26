<?php
login_required();
$feed = Feed::find($params['id']);
if ($feed->exists()) {
	$feed_user = FeedUser::find_by_user_and_feed($account, $feed);
	if ($feed_user->exists()) {
		$feed_user->set_attribute('trackback-key', md5(microtime() . uniqid(rand(), true)));
		$feed_user->set_attribute('owner-id',$account->id);
		Flash::set('트랙백 인증키가 발급되었습니다');
	}
}
if(is_xhr()) {
	include 'themes/'.get_current_theme().'/_homepage.php';
	exit;
} else
	redirect_back();
?>