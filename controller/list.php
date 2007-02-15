<?php
require 'lib/page.php';

$style->set('posts', $board->get_posts_in_page(get_requested_page()));
$style->set('massdelete', $account->level >= $board->perm_delete);
if ($account->level >= $board->perm_write)
	$style->set('link_new_post', url_for($board, 'post'));
$style->render('list');
?>
