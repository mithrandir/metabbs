<?php
requireCore('feed');

$title = 'Full site feed (comments)';
$url = full_url_for('feed', 'comments');
$comments = Site::get_latest_comments(20);
apply_filters_array('CommentViewFeed', $comments);

feed_header();
include 'app/views/default/feed/comments.php';
exit;
