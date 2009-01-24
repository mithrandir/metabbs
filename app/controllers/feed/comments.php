<?php
require_once 'core/feed.php';

$title = 'Full site feed (comments)';
$url = url_for('feed', 'comments');
$comments = Site::get_latest_comments(20);
apply_filters_array('CommentViewFeed', $comments);

feed_header();
include 'app/views/feed/comments.php';
exit;
