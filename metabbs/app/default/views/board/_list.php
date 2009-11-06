<?php
require_once 'core/page.php';

if (isset($keyword)) {
	$template->set('keyword', $keyword);
	foreach (array('author', 'title', 'body', 'comment', 'tag') as $key) {
		if (isset($_GET[$key]) && $_GET[$key]) {
			$finder->add_condition($key);
			$template->set($key.'_checked', 'checked="checked"');
		} else {
			$template->set($key.'_checked', '');
		}
	}
} else {
	$template->set('keyword', '');
	$template->set('author_checked', '');
	$template->set('title_checked', 'checked="checked"');
	$template->set('body_checked', '');
	$template->set('comment_checked', '');
	$template->set('tag_checked', '');
}

if ($board->use_category) {
	$template->set('categories', $categories);
	if (isset($category))
		$template->set('category', $category);
}

$template->set('posts', $posts);
$template->set('post_count', $count = $board->get_post_count());
$template->set('posts_count', $count); // backward compatibility
if (isset($notices)) $template->set('notices', $notices);

$template->set('link_rss', url_for($board, 'rss'));
$template->set('link_new_post', $account->has_perm('write', $board) ? url_for($board, 'post', get_search_params()) : null);
$template->set('admin', $account->has_perm('admin', $board));

$page = get_requested_page();
$count = $finder->get_post_count();
$_pages = New Pages(null, $board);
$pages = $_pages->get_pages($page, $count, $board->posts_per_page, 5);
$template->set('pages', $pages);
//$template->set('pages_nav',get_board_pages());
