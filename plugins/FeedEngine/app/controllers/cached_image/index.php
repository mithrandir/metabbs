<?php
require_once('../../../simplepie.inc.php');
SimplePie_Misc::display_cached_file($_GET['q'], '../../../../../data/feed_cache', 'spi');
?>
