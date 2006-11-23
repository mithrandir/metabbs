<?php
function link_to_page($board, $page, $text = null) {
	return link_to(!$text ? $page : $text, $board, '', array('page' => $page));
}
function print_pages($board, $padding = 2) {
	$page = get_requested_page();
	$count = $board->get_post_count_with_condition();
	$page_count = $count ? ceil($count / $board->posts_per_page) : 1;
	$prev_page = $page - 1;
	$next_page = $page + 1;
	$page_group_start = $page - $padding;
	if ($page_group_start < 1) $page_group_start = 1;
	$page_group_end = $page + $padding;
	if ($page_group_end > $page_count) $page_group_end = $page_count;
	
	echo '<ul id="pages">';
	if ($prev_page > 0) {
		echo block_tag('li', link_to_page($board, $prev_page, '&lsaquo;'), array('class' => 'prev'));
	}
	if ($page_group_start > 1) {
		echo block_tag('li', link_to_page($board, 1));
		if ($page_group_start > 2) echo block_tag('li', '...');
	}
	for ($p = $page_group_start; $p <= $page_group_end; $p++) {
		echo block_tag('li', link_to_page($board, $p), $p == $page ? array('class' => 'here') : array());
	}
	if ($page_group_end != $page_count) {
		if ($page_group_end < ($page_count - 1)) echo block_tag('li', '...');
		echo block_tag('li', link_to_page($board, $page_count));
	}
	if ($next_page <= $page_count) {
		echo block_tag('li', link_to_page($board, $next_page, '&rsaquo;'), array('class' => 'next'));
	}
	echo "</ul>";
}
?>
