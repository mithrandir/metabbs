<?php
$page = new Page($user_, Page::get_requested_page());
$board = $user_; // XXX
$posts = $page->get_posts();
$pages = $page->get_page_group();

render('user');
?>
