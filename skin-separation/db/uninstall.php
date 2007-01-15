<?php
$tables = array('board', 'post', 'comment', 'attachment', 'trackback', 'user', 'category', 'plugin');
foreach ($tables as $table) {
	$conn->drop_table($table);
}
?>
