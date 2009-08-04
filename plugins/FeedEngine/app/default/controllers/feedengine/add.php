<?php
login_required();
$result = FeedParser::relate_feed_by_user($params['feed_url'], $account);
Flash::set($result ? i('Feed Added') : i('Feed doesn\'t Add'));
if(is_xhr()) {
	include 'themes/'.get_current_theme().'/_homepage.php';exit;
} else {
	redirect_back();
}
?>