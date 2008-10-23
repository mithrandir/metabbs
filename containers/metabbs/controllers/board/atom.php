<?php
require_once 'core/feed.php';
permission_required('list', $board);
render_board_feed($board, 'atom');
