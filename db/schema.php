<?php
$t = new Table('board');
$t->column('name', 'string', 45);
$t->column('posts_per_page', 'integer');
$t->column('style', 'string', 45);
$t->column('title', 'string', 255);
$t->column('use_attachment', 'boolean');
$t->column('use_category', 'boolean');
$t->column('use_trackback', 'boolean');
$t->column('perm_read', 'ushort');
$t->column('perm_write', 'ushort');
$t->column('perm_comment', 'ushort');
$t->column('perm_delete', 'ushort');
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
$t->column('type', 'ushort');
$t->column('views', 'integer');
$t->column('secret', 'boolean');
$t->column('edited_at', 'timestamp');
$t->column('edited_by', 'integer');
$t->add_index('board_id');
$t->add_index('category_id');
$t->add_index('user_id');
$conn->add_table($t);

$t = new Table('comment');
$t->column('board_id', 'integer');
$t->column('post_id', 'integer');
$t->column('user_id', 'integer');
$t->column('parent', 'integer');
$t->column('name', 'string', 45);
$t->column('body', 'text');
$t->column('password', 'string', 32);
$t->column('created_at', 'timestamp');
$t->add_index('post_id');
$t->add_index('board_id');
$conn->add_table($t);

$t = new Table('attachment');
$t->column('post_id', 'integer');
$t->column('filename', 'string', 255);
$t->column('type', 'string', 50);
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
$t->column('signature', 'text');
$t->column('token', 'string', 32);
$conn->add_table($t);

$t = new Table('category');
$t->column('board_id', 'integer');
$t->column('name', 'string', 45);
$t->add_index('board_id');
$conn->add_table($t);

$t = new Table('plugin');
$t->column('name', 'string', 45);
$t->column('enabled', 'boolean');
$t->add_index('name');
$t->add_index('enabled');
$conn->add_table($t);
?>
