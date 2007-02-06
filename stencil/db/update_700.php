<?php
function convert_timestamp_to_integer($model, $column) {
	$db = get_conn();
	$table = get_table_name($model);
	$db->query("ALTER TABLE $table MODIFY COLUMN $column VARCHAR(19) NOT NULL");
	$db->query("UPDATE $table SET $column=UNIX_TIMESTAMP($column)");
	$db->query("ALTER TABLE $table MODIFY COLUMN $column INTEGER UNSIGNED NOT NULL");
}

convert_timestamp_to_integer('post', 'created_at');
convert_timestamp_to_integer('comment', 'created_at');
?>
