<?php
/**
 * 해당 페이지의 링크를 만든다.
 * @param $board 게시판 명
 * @param $page 페이지
 * @param $text 출력할 문자열
 * @return 게시판 명과 페이지를 기준으로 링크를 만든다.
 * $text가 있는 경우에는 텍스트를 없는 경우엔 페이지 번호를 텍스트로 삼는다.
 */
function link_to_page($page, $text = null) {
	$params = get_search_params();
	$params['page'] = $page;
	return link_text(query_string_for($params), $text ? $text : $page);
}

function url_for_page($page) {
	$params = get_search_params();
	$params['page'] = $page;
	return query_string_for($params);
}

/**
 * 실제 페이지를 출력한다.
 * @param $board 게시판명
 * @param $padding 앞뒤로 필요한 간격
 */
function print_pages($board, $padding = 2) {
	global $finder;
	$page = get_requested_page();
	$count = $finder->get_post_count();
	_print_pages($page, $count, $board->posts_per_page, $padding);
}

function _print_pages($page, $count, $per_page, $padding = 2) {
	$page_count = $count ? ceil($count / $per_page) : 1;
	$prev_page = $page - 1;
	$next_page = $page + 1;
	$page_group_start = $page - $padding;
	if ($page_group_start < 1) $page_group_start = 1;
	$page_group_end = $page + $padding;
	if ($page_group_end > $page_count) $page_group_end = $page_count;
	
	echo '<ul id="pages">';
	if ($prev_page > 0) {
		echo '<li class="prev">'.link_to_page($prev_page, '&lsaquo;').'</li>';
	}
	if ($page_group_start > 1) {
		echo '<li>'.link_to_page(1).'</li>';
		if ($page_group_start > 2) echo '<li>...</li>';
	}
	for ($p = $page_group_start; $p <= $page_group_end; $p++) {
		if ($p == $page) echo '<li class="here">';
		else echo '<li>';
		echo link_to_page($p) . '</li>';
	}
	if ($page_group_end != $page_count) {
		if ($page_group_end < ($page_count - 1)) echo '<li>...</li>';
		echo '<li>'.link_to_page($page_count).'</li>';
	}
	if ($next_page <= $page_count) {
		echo '<li class="next">'.link_to_page($next_page, '&rsaquo;').'</li>';
	}
	echo "</ul>";
}
?>
