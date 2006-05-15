<?php
$page = new Page($board, Page::get_requested_page());
$posts = $page->get_posts();
$pages = $page->get_page_group();
?>
