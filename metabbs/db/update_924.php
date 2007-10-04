<?php
$db = get_conn();
$table = get_table_name('board');
$db->query("ALTER TABLE $table CHANGE order_by order_by VARCHAR(60) NOT NULL");
?>
