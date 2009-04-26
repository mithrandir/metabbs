<?php
$feed = Feed::find($params['id']);
$user = User::find($params['user']);
if (!$feed->exists() || !$user->exists()) {
	header('HTTP/1.1 404 Not Found');
	print_notice(i('Feed not found'), i("Feed #%d doesn't exist.", $params['id']));
}
$feed_user = FeedUser::find_by_user_and_feed($user, $feed);
$parsed = parse_url($params['url']);

if(empty($params['url']) || empty($params['key']) || strstr($feed->link, $parsed['scheme']."://".$parsed['host']."/") > 0) {
	header('HTTP/1.1 403 Forbidden');
	print_notice(i('Invalid Request'), i('This Page is not Available.'));
}
//		DEBUG CODE
/*ob_start();
echo "========================";
var_dump($params['key']);
var_dump($feed_user->get_attribute('trackback-key'));
var_dump($params['url']);
$content = ob_get_contents();
ob_end_clean();
$fp = fopen(METABBS_DIR . '/test.log', 'a');
fwrite($fp, $content);
fclose($fp);*/
header("Content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<response>\n";
if($feed_user->get_attribute('trackback-key') == $params['key']) {
	$feed->owner_id = $feed_user->get_attribute('owner-id');
	$feed->active = true;
	$feed->update();
	$feed_user->remove_attribute('trackback-key');
	$feed_user->remove_attribute('owner-id');
	$feed_user->membed_id = 1;
	$feed_user->update();
	echo "<error>0</error>\n";
} else {
	echo "<error>1</error>\n";
	echo "<message>Unable to authorize trackback</message>\n";
}
echo '</response>';
exit;
?>