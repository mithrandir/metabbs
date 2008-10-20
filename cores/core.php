<?php
define('METABBS_VERSION', '0.11');

require METABBS_DIR . '/cores/config.php';
$config = new Config(METABBS_DIR . '/metabbs.conf.php');

$backend = $config->get('backend', 'mysql');
if (!defined('METABBS_BASE_PATH')) {
	define('METABBS_BASE_PATH', $config->get('base_path', $metabbs_base_path));
}

require METABBS_DIR . '/cores/query.php';
require METABBS_DIR . '/cores/model.php';
require METABBS_DIR . '/cores/backends/' . $backend . '/backend.php';
$__db = get_conn();
set_table_prefix($config->get('prefix', 'meta_'));

require METABBS_DIR . '/app/models/site.php';
require METABBS_DIR . '/app/models/board.php';
require METABBS_DIR . '/app/models/category.php';
require METABBS_DIR . '/app/models/uncategorized_posts.php';
require METABBS_DIR . '/app/models/post.php';
require METABBS_DIR . '/app/models/post_finder.php';
require METABBS_DIR . '/app/models/comment.php';
require METABBS_DIR . '/app/models/trackback.php';
require METABBS_DIR . '/app/models/attachment.php';
require METABBS_DIR . '/app/models/user.php';
require METABBS_DIR . '/app/models/plugin.php';
require METABBS_DIR . '/app/models/tag.php';
require METABBS_DIR . '/app/models/tag_post.php';

require METABBS_DIR . '/cores/template.php';
require METABBS_DIR . '/cores/uri_manager.php';
require METABBS_DIR . '/cores/account.php';
require METABBS_DIR . '/cores/timezone.php';
require METABBS_DIR . '/cores/external.php';
?>
