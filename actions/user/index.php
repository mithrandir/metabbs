<?php
$page = new Page($user, Page::get_requested_page());
$board = $user; // XXX
$posts = $page->get_posts();
$pages = $page->get_page_group();
?>
