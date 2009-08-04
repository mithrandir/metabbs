<?php
login_required();
if (is_post()) {
	$feed = Feed::find($params['id']);
	if ($feed->exists()) {
		$feed_user = FeedUser::find_by_user_and_feed($account, $feed);
		if ($feed_user->exists()){
			$feed_user->remove_attribute('trackback-key');
			$feed_user->remove_attribute('owner-id');
		}
		if($feed->owner_id == $account->id)
			$feed->delete();
		else
			$feed->unrelate_to_user($account);
	}
	Flash::set('피드가 삭제되었습니다');	
}
if(is_xhr()) {
	include 'themes/'.get_current_theme().'/_homepage.php';exit;
} else {
	redirect_back();
}
?>