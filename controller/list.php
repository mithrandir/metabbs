<?php
require 'lib/page.php';

if ($account->level < $board->perm_read)
	access_denied();

$posts = $board->get_posts_in_page(get_requested_page());
apply_filters_array('PostList', $posts);

$style->set('posts', $posts);
$style->set('massdelete', $account->level >= $board->perm_delete);
if ($account->level >= $board->perm_write)
	$style->set('link_new_post', url_for($board, 'post'));
$style->render('list');
?>
