<?php
$t = new Table('trash');
$t->column('model', 'string', 255);
$t->column('data', 'text');
$t->column('reason', 'string', 255);
$t->column('created_at', 'timestamp');
$conn->add_table($t);
?>
