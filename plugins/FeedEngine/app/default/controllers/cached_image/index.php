<?php
require_once(METABBS_DIR . '/plugins/FeedEngine/simplepie.inc.php');
SimplePie_Misc::display_cached_file($params['q'], METABBS_DIR .'/data/feed_cache', 'spi');
?>
