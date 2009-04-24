<?php
if(!isset($argv[1]) || !isset($argv[2]) || !isset($argv[3])) {
	echo "Usage : php update_all_feed.php [board_name] [host_url] [metabbs_dir]\n";
//	ex) sudo -u apache php ./update_all_feed.php feed http://hosting.yupmin.com /home/yupmin/sites/yupmin.com/hosting/metabbs >> /home/yupmin/sites/0jin0.net/www/metabbs/data/feed_log/progess.log 2 >> /home/yupmin/sites/0jin0.net/www/metabbs/data/feed_log/error.log
	exit;
}

$board_name = $argv[1];
$host_url = $argv[2];
$metabbs_dir = $argv[3];

$path = dirname($_SERVER['SCRIPT_NAME']);
if ($path == '\\' || $path == '/') $path = '';
$metabbs_base_path = $path . '/';	

define('METABBS_HOST_URL', $host_url);
define('METABBS_DIR', $metabbs_dir);		// '../../..'

function requireCore($name) {
	global $_requireCore;
	if(!in_array($name,$_requireCore)) {
		include_once (METABBS_DIR . "/core/$name.php");
		array_push($_requireCore,$name);
	}
}
function requireModel($name) {
	global $_requireModels;
	if(!in_array($name,$_requireModels)) {
		include_once (METABBS_DIR . "/app/models/$name.php");
		array_push($_requireModels,$name);
	}
}

$_requireCore = $_requireModels = array();
require METABBS_DIR . '/core/core.php';

$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

import_default_language();

$tz = $config->get('timezone');
if ($tz) Timezone::set($tz);
$account = new Guest;
import_enabled_plugins();

echo "-- library loaded\n";

$board = Board::find_by_name($board_name);

switch ($board->get_attribute('feed-range')) {
	case 0:
		$feeds = Feed::find_all();
		break;
	case 1:
		$feeds = Feed::find_all_having_owner();
		break;
	case 2:
		$feeds = Feed::find_all_by_board($board);
		break;
	case 3:
		$feeds = Feed::find_all_by_board_having_owner($board);
		break;
}
foreach($feeds as $feed) {
	if (!empty($feed->url) && $feed->active) {
		echo $feed->link." have feeding... ";
		FeedParser::collect_feed_to_board($feed, $board);
		echo "done!!\n";
	}
}
echo "-- Feeding ended\n\n";
?>