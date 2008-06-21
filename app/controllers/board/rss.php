<?php
require_once 'lib/feed.php';
permission_required('list', $board);
render_board_feed($board, 'rss');
