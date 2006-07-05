<?php
if ($board->perm_read > $user->level) {
	access_denied();
}
if (isset($_GET['searchtype']) && isset($_GET['search'])) {
	$board->searchtype = $_GET['searchtype'];
	$board->search = $_GET['search'];
}
$posts = $board->get_posts((get_requested_page() - 1) * $board->posts_per_page, $board->posts_per_page);

$nav[] = link_to(i("New Post"), $board, 'post');

render('list');
?>
