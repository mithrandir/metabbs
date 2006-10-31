<?php
if ($board->perm_read > $account->level) {
	access_denied();
}
if (isset($_GET['search'])) {
	$board->search = array_merge($board->search, $_GET['search']);
}
if ($board->use_category) {
	if ($board->search['category'])
		$category = Category::find($board->search['category']);
	$categories = $board->get_categories();
}
if ($board->search['comment']) {
	$posts = $board->get_posts_in_page(get_requested_page(), 'search_posts_with_comment');
} else {
	$posts = $board->get_posts_in_page(get_requested_page());
}

apply_filters_array('PostView', $posts);

$posts_count = $board->get_post_count();
$link_rss = url_for($board, 'rss');
$link_new_post = ($board->perm_write <= $account->level) ? url_for($board, 'post') : null;

render('list');
?>
