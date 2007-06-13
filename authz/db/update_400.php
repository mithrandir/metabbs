<?php
$t = new Table('category');
$t->column('board_id', 'integer');
$t->column('name', 'string', 45);
$t->add_index('board_id');
$conn->add_table($t);

$conn->add_field('post', 'category_id', 'integer');
$conn->add_index('post', 'category_id');

$conn->add_field('board', 'use_category', 'integer', 1);
?>
