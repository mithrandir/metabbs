<?php
$tables = array('board', 'board_admin', 'post', 'metadata', 'comment', 'attachment', 'trackback', 'user', 'category', 'plugin');
foreach ($tables as $table) {
	$conn->drop_table($table);
}
?>
