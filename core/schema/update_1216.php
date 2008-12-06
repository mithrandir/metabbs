<?php
	$t = new Table('board_member');
	$t->column('board_id', 'integer');
	$t->column('user_id', 'integer');
	$t->add_index('board_id');
	$conn->add_table($t);
	$conn->query("INSERT INTO ".get_table_name('board_member')." (board_id, user_id) VALUES(0, 0)"); // insert dummy data
