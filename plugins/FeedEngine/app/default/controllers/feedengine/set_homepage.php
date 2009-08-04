<?php
login_required();
$feed = Feed::find($params['id']);
if($feed->exists()){
	$account->url = $feed->link;
	$account->update();
}
if(is_xhr()) {
	include 'themes/'.get_current_theme().'/_homepage.php';exit;
} else
	redirect_back();
?>