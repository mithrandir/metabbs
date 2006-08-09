<?php
if ($board->perm_read > $account->level) {
	access_denied();
}
if (isset($_GET['search'])) {
	$board->search = array_merge($board->search, $_GET['search']);
}
if ($board->search['category'] && $board->use_category) {
	$category = Category::find($board->search['category']);
}
$posts = $board->get_posts((get_requested_page() - 1) * $board->posts_per_page, $board->posts_per_page);

$nav[] = link_to(i("New Post"), $board, 'post');

render('list');
?>
