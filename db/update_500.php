<?php
$t = new Table('plugin');
$t->column('name', 'string', 45);
$t->column('enabled', 'integer', 1);
$t->add_index('name');
$t->add_index('enabled');
$conn->add_table($t);
?>
