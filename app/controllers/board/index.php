<?php
permission_required('list', $board);

$style = $board->get_style();
$template = $style->get_template('list');
$template->set('board', $board);

if (isset($_GET['search'])) {
	// backward compatibility
	$_GET['search']['keyword'] = $_GET['search']['text'];
	unset($_GET['search']['text']);
	redirect_to(query_string_for($_GET['search']));
}

$finder = new PostFinder($board);
$board->finder = $finder;
if ($board->order_by) $finder->order_by($board->order_by);
$finder->set_page(get_requested_page());
$finder->get_post_body = $style->skin->get_option('get_body_in_the_list', true);

if (isset($_GET['keyword']) && $_GET['keyword']) {
	$keyword = $_GET['keyword'];
	$finder->set_keyword($keyword);
	$template->set('keyword', $keyword);
	foreach (array('title', 'body') as $key) {
		if (isset($_GET[$key]) && $_GET[$key]) {
			$finder->add_condition($key);
			$template->set($key.'_checked', 'checked="checked"');
		} else {
			$template->set($key.'_checked', '');
		}
	}
} else {
	$template->set('keyword', '');
	$template->set('title_checked', 'checked="checked"');
	$template->set('body_checked', '');
}

if ($board->use_category) {
	$categories = $board->get_categories();
	$un = new UncategorizedPosts($board);
	if ($un->exists())
		array_unshift($categories, $un);
	$template->set('categories', $categories);
	if (isset($_GET['category'])) {
		if ($_GET['category'] == 0)
			$category = new UncategorizedPosts($board);
		else
			$category = Category::find($_GET['category']);
		$finder->set_category($category);
		$template->set('category', $category);
	}
}
$posts = $finder->get_posts();
apply_filters_array('PostList', $posts);

$template->set('posts', $posts);
$template->set('posts_count', $board->get_post_count());
$template->set('link_rss', url_for($board, 'rss'));
$template->set('link_new_post', $account->has_perm('write', $board) ? url_for($board, 'post') : null);
$template->set('massdelete', $account->has_perm('admin', $board));
?>
