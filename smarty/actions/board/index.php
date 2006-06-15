<?php
if ($board->perm_read > $user->level) {
	access_denied();
}
if (isset($_GET['searchtype']) && isset($_GET['search'])) {
	$board->searchtype = $_GET['searchtype'];
	$board->search = $_GET['search'];
}
$page = new Page($board, Page::get_requested_page());
$posts = $page->get_posts();

$nav[] = link_to(i("New Post"), $board, 'post');

render('list');
?>
