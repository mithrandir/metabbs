Older posts:
<?php
$page = get_requested_page();
$count = $board->get_post_count_with_condition();
$page_count = $count ? ceil($count / $board->posts_per_page) : 1;
if (($page_group_start = $page - 2) < 1) $page_group_start = 1;
if (($page_group_end = $page + 2) > $page_count) $page_group_end = $page_count;

if ($page_group_start > 1) {
	echo link_to_page($board, 1);
	if ($page_group_start > 2) echo ' ... ';
}
for ($i = $page_group_start; $i <= $page_group_end; $i++) {
	if ($i == $page)
		echo ' ' . $i;
	else
		echo ' ' . link_to_page($board, $i);
}
if ($page_group_end != $page_count) {
	if ($page_group_end < $page_count) echo ' ... ';
	echo ' ' . link_to_page($board, $page_count);
}
?>
