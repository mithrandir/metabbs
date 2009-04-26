<?php
requireCoreofPlugin('FeedEngine', 'simplepie');
SimplePie_Misc::display_cached_file($params['q'], METABBS_DIR .'/data/feed_cache', 'spi');
?>
