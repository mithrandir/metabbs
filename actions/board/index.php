<?php
if ($board->perm_read > $user->level) {
	access_denied();
}
if (isset($_GET['searchtype'])) {
	$board->searchtype = $_GET['searchtype'];
}
if (isset($_GET['search'])) {
	$board->search = $_GET['search'];
}
$page = new Page($board, Page::get_requested_page());
$posts = $page->get_posts();
$pages = $page->get_page_group();

render('list');
?>
