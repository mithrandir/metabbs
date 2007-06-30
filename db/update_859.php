<?php
function convert_integer_to_boolean($model, $old_column, $new_column) {
	$db = get_conn();
	$table = get_table_name($model);
	$db->query("ALTER TABLE $table CHANGE $old_column $new_column BOOL NOT NULL");
}

convert_integer_to_boolean('post', 'type', 'notice');
?>
