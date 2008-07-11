<?php
$conn->add_field('board_member', 'admin', 'boolean');
$result = $conn->query("SELECT * FROM " . get_table_name('board_admin'));
while ($row = $result->fetch()) {
	if (!$row['board_id']) continue;
	$conn->query("INSERT INTO " . get_table_name('board_member') . " (board_id, user_id, admin) VALUES($row[board_id], $row[user_id], 1)");
}
$conn->drop_table('board_admin');
