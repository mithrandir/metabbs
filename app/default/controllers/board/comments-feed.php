<?php
require_once 'core/feed.php';

$title = $board->get_title();
$url = full_url_for($board, 'comments-feed');
$comments = $board->get_recent_comments(20);
apply_filters_array('CommentViewFeed', $comments);

feed_header();
include 'app/views/feed/comments.php';
exit;
