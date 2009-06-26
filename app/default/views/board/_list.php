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

$page_count = $matched_post_count ? ceil($matched_post_count / $board->posts_per_page) : 1;
$prev_page = $page - 1;
$next_page = $page + 1;
$page_group_start = $page - 5;
if ($page_group_start < 1) $page_group_start = 1;
$page_group_end = $page + 5;
if ($page_group_end > $page_count) $page_group_end = $page_count;

$template->set('link_prev_page', $prev_page > 0 ? url_for_page($prev_page, $board) : null);
$template->set('link_next_page', $next_page <= $page_count ? url_for_page($next_page, $board) : null);
$pages = array();	
if ($page_group_start > 1) {
	$pages[] = link_to_page(1, null, $board);
	if ($page_group_start > 2) $pages[] = '...';
}
for ($p = $page_group_start; $p <= $page_group_end; $p++) {
	if ($p == $page) $pages[] = '<span class="here">'.link_to_page($p, null, $board).'</span>';
	else $pages[] = link_to_page($p, null, $board);
}
if ($page_group_end != $page_count) {
	if ($page_group_end < ($page_count - 1)) $pages[] = '...';
	$pages[] = link_to_page($page_count, null, $board);
}
$template->set('pages', $pages);
