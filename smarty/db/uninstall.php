<?php
$tables = array('board', 'post', 'comment', 'attachment', 'trackback', 'user');
foreach ($tables as $table) {
	$conn->drop_table($table);
}
?>
