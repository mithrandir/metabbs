<?php
require_once 'core/feed.php';
render_feed('Full site feed', full_url_for('feed'), '',
		Site::get_latest_posts(10), 'atom');
