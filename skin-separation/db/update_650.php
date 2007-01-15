<?php
$table = get_table_name('board');
$conn->query("DELETE FROM $table WHERE name=''");
?>
