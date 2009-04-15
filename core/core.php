<?php
define('METABBS_VERSION', '0.12-devel');
define('DEFAULT_VIEW', 0);
define('ADMIN_VIEW', 1);

requireCore('config');
$config = new Config(METABBS_DIR . '/metabbs.conf.php');

$backend = $config->get('backend', 'mysql');
if (!defined('METABBS_BASE_PATH')) {
	define('METABBS_BASE_PATH', $config->get('base_path', $metabbs_base_path));
}
requireCore('query');
$__cache = new ObjectCache;
requireCore('model');
requireCore('backends/' . $backend . '/backend');

$__db = get_conn();
set_table_prefix($config->get('prefix', 'meta_'));

requireModel('site');
requireModel('board');
requireModel('category');
requireModel('uncategorized_posts');
requireModel('post');
requireModel('post_finder');
requireModel('comment');
requireModel('trackback');
requireModel('attachment');
requireModel('user');
requireModel('plugin');
requireModel('tag');
requireModel('tag_post');

requireCore('template');
requireCore('account');
requireCore('timezone');
requireCore('dispatcher');
?>
