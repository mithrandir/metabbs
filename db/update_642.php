<?php
$conn->add_field('board', 'use_trackback', 'boolean');
$table = get_table_name('board');
$conn->query("UPDATE $table SET use_trackback=1");
?>
