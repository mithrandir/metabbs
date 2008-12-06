<?php
	$t = new Table('tag');
	$t->column('name', 'string', 255);
	$t->column('board_id', 'integer');
	$t->column('post_count', 'integer');
	$t->column('updated_at', 'timestamp');
	$t->add_index('name');
	$t->add_index('board_id');
	$conn->add_table($t);

	$t = new Table('tag_post');
	$t->column('post_id', 'integer');
	$t->column('tag_id', 'integer');
	$t->column('created_at', 'timestamp');
	$t->add_index('post_id');
	$t->add_index('tag_id');
	$conn->add_table($t);

	$conn->add_field('post', 'tag_count', 'integer');
	$conn->add_field('post', 'tags', 'string', 255);
?>