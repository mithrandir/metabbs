<?php
login_required();
Flash::set(FeedParser::relate_feed_by_user($params['feed_url'], $account) ? i('Feed Added') : i('Feed doesn\'t Add'));
if(is_xhr()) {
	include 'themes/'.get_current_theme().'/_homepage.php';exit;
} else
	redirect_back();
?>