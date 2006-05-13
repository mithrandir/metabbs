<?php
if ($board->perm_read > $user->level) {
	redirect_to(url_for('user', 'login', true));
}
if (isset($_GET['search'])) {
	$board->search = $_GET['search'];
}
$page = new Page($board, Page::get_requested_page());
$posts = $page->get_posts();
$pages = $page->get_page_group();
?>