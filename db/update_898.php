<?php
$description = "adding board administrators table";

$t = new Table('board_admin');
$t->column('board_id', 'integer');
$t->column('user_id', 'integer');
$t->add_index('board_id');
$conn->add_table($t);

$board_table = get_table_name('board');
$user_table = get_table_name('user');
$table = get_table_name('board_admin');
$result = $conn->get_result("SELECT b.id AS board_id, u.id AS user_id FROM $board_table b, $user_table u WHERE u.level >= b.perm_delete AND u.level < 255");
while ($row = $result->fetch()) {
	$conn->query("INSERT INTO $table (board_id, user_id) VALUES($row[board_id], $row[user_id])");
}

$conn->drop_field('board', 'perm_delete');
?>
