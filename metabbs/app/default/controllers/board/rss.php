<?php
require_once 'core/feed.php';
permission_required('list', $board);
echo render_board_feed($board, 'rss');
exit;
