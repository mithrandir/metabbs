<?php
require_once 'cores/feed.php';
permission_required('list', $board);
render_board_feed($board, 'rss');
