<?php
$t = new Table('board');
$t->column('name', 'string', 45);
$t->column('posts_per_page', 'integer');
$t->column('skin', 'string', 45);
$t->column('title', 'string', 255);
$t->column('use_attachment', 'integer', 1);
$t->column('use_category', 'integer', 1);
$t->column('perm_read', 'integer', 3);
$t->column('perm_write', 'integer', 3);
$t->column('perm_comment', 'integer', 3);
$t->column('perm_delete', 'integer', 3);
$t->add_index('name');
$conn->add_table($t);

$t = new Table('post');
$t->column('board_id', 'integer');
$t->column('user_id', 'integer');
$t->column('category_id', 'integer');
$t->column('name', 'string', 45);
$t->column('title', 'string', 255);
$t->column('body', 'text');
$t->column('password', 'string', 32);
$t->column('created_at', 'timestamp');
$t->column('type', 'integer', 1);
$t->add_index('board_id');
$t->add_index('category_id');
$t->add_index('user_id');
$conn->add_table($t);

$t = new Table('comment');
$t->column('post_id', 'integer');
$t->column('user_id', 'integer');
$t->column('name', 'string', 45);
$t->column('body', 'text');
$t->column('password', 'string', 32);
$t->column('created_at', 'timestamp');
$t->add_index('post_id');
$conn->add_table($t);

$t = new Table('attachment');
$t->column('post_id', 'integer');
$t->column('filename', 'string', 255);
$t->add_index('post_id');
$conn->add_table($t);

$t = new Table('trackback');
$t->column('post_id', 'integer');
$t->column('blog_name', 'string', 255);
$t->column('title', 'string', 255);
$t->column('excerpt', 'text');
$t->column('url', 'string', 255);
$t->add_index('post_id');
$conn->add_table($t);

$t = new Table('user');
$t->column('user', 'string', 45);
$t->column('password', 'string', 32);
$t->column('name', 'string', 45);
$t->column('email', 'string', 255);
$t->column('url', 'string', 255);
$t->column('level', 'integer');
$conn->add_table($t);

$t = new Table('category');
$t->column('board_id', 'integer');
$t->column('name', 'string', 45);
$t->add_index('board_id');
$conn->add_table($t);
?>
