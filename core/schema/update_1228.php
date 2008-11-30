<?php
$conn->add_field('category', 'position', 'integer');
$board_result = $conn->query("SELECT id FROM " . get_table_name('board') . " WHERE use_category = 1");
while ($board = $board_result->fetch()) {
	if (!$board['id']) continue;
	$category_result = $conn->query("SELECT id FROM " . get_table_name('category') . " WHERE board_id = {$board['id']} ORDER BY name ASC");
	$position = 1;
	while ($category = $category_result->fetch()) {
		$conn->query("UPDATE " . get_table_name('category') . " SET position = $position WHERE id = {$category['id']}");
		$position ++;
	}
}

