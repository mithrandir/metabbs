<?php
$tables = array('board', 'post', 'comment', 'attachment', 'trackback', 'user', 'category', 'plugin');
foreach ($tables as $table) {
	$conn->drop_table($table);
}

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
