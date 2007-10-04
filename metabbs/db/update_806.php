<?php
$t = new Table('post_meta');
$t->column('post_id', 'integer');
$t->column('key', 'string', 45);
$t->column('value', 'string', 255);
$t->add_index('post_id');
$conn->add_table($t);
?>
