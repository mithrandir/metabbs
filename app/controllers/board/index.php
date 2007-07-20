<?php
permission_required('list', $board);

if (isset($_GET['search'])) {
	$board->search = array_merge($board->search, $_GET['search']);
}

$template = $board->get_style()->get_template('list');
$template->set('board', $board);

if ($board->use_category) {
	if ($board->search['category'])
		$template->set('category', Category::find($board->search['category']));
	$template->set('categories', $board->get_categories());
}
if ($board->search['comment'] && $board->search['text']) {
	$posts = $board->get_posts_in_page(get_requested_page(), 'search_posts_with_comment');
} else {
	$posts = $board->get_posts_in_page(get_requested_page());
}
apply_filters_array('PostList', $posts);

$template->set('posts', $posts);
$template->set('posts_count', $board->get_post_count());
$template->set('link_rss', url_for($board, 'rss'));
$template->set('link_new_post', $account->has_perm('write', $board) ? url_for($board, 'post') : null);
$template->set('massdelete', $account->has_perm('admin', $board));
?>
