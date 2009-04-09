<?php
define('METABBS_DB_REVISION', 1428);

function run($conn) {
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
	$t->column('perm_attachment', 'ushort');
	$t->column('order_by', 'string', 60);
	$t->column('header', 'string', 255);
	$t->column('footer', 'string', 255);
	$t->add_index('name');
	$conn->add_table($t);

	$t = new Table('board_member');
	$t->column('board_id', 'integer');
	$t->column('user_id', 'integer');
	$t->column('admin', 'boolean');
	$t->add_index('board_id');
	$conn->add_table($t);
	$conn->query("INSERT INTO ".get_table_name('board_member')." (board_id, user_id, admin) VALUES(0, 0, 0)"); // insert dummy data

	$t = new Table('post');
	$t->column('board_id', 'integer');
	$t->column('user_id', 'integer');
	$t->column('category_id', 'integer');
	$t->column('name', 'string', 45);
	$t->column('title', 'string', 255);
	$t->column('body', 'longtext');
	$t->column('password', 'string', 32);
	$t->column('tags', 'string', 255);
	$t->column('created_at', 'timestamp');
	$t->column('notice', 'boolean');
	$t->column('views', 'integer');
	$t->column('secret', 'boolean');
	$t->column('edited_at', 'timestamp');
	$t->column('edited_by', 'integer');
	$t->column('moved_to', 'integer');
	$t->column('last_update_at', 'timestamp');
	$t->column('comment_count', 'integer');
	$t->column('attachment_count', 'integer');
	$t->column('tag_count', 'integer');
	$t->column('sort_key', 'integer');
	$t->add_index('board_id');
	$t->add_index('category_id');
	$t->add_index('user_id');
	$conn->add_table($t);

	$t = new Table('metadata');
	$t->column('model', 'string', 20);
	$t->column('model_id', 'integer');
	$t->column('key', 'string', 45);
	$t->column('value', 'string', 255);
	$t->add_index('model_id');
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
	$t->column('position', 'integer');
	$t->add_index('board_id');
	$conn->add_table($t);

	$t = new Table('plugin');
	$t->column('name', 'string', 45);
	$t->column('installed_version', 'integer');
	$t->column('enabled', 'boolean');
	$t->add_index('name');
	$t->add_index('enabled');
	$conn->add_table($t);
}
?>
