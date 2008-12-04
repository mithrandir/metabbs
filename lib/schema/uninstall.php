<?php
$tables = array('board', 'board_member', 'post', 'metadata', 'comment', 'attachment', 'trackback', 'user', 'category', 'plugin', 'tag_post', 'tag');
foreach ($tables as $table) {
	$conn->drop_table($table);
}
?>
