<?php
$conn->add_field('post', 'sort_key', 'integer');

foreach (Board::find_all() as $board)
	$board->reset_sort_keys();
?>
