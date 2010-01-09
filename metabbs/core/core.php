<?php
define('METABBS_VERSION', '0.99-devel');

requireCore('config');
$config = new Config(METABBS_DIR . '/metabbs.conf.php');
$reserved_containers = array_map('trim', explode(',',$config->get('reserved_containers')));

$backend = $config->get('backend', 'mysql');
if (!defined('METABBS_BASE_PATH')) {
	define('METABBS_BASE_PATH', $config->get('base_path', $metabbs_base_path));
}
requireCore('query');
requireCore('relation');
$__cache = new ObjectCache;
requireModel('metadata');
requireCore('model');
requireCore('backends/' . $backend . '/backend');

$__db = get_conn();
set_table_prefix($config->get('prefix', 'meta_'));

$filters = array();
$handlers = array();
$__plugins = array();
$__admin_menu = array();
$extra_attributes = array();

// core
requireModel('user');
requireModel('plugin');
// common
requireModel('site');
requireModel('board');
requireModel('category');
requireModel('uncategorized_posts');
requireModel('post');
requireModel('post_finder');
requireModel('comment');
requireModel('trackback');
requireModel('attachment');
requireModel('tag');
requireModel('tag_post');
requireModel('openid');
requireModel('trash');

// core
requireCore('template');
requireCore('account');
requireCore('timezone');
requireCore('permission');
requireCore('request');
requireCore('i18n');
requireCore('cookie');
requireCore('tag_helper');
requireCore('plugin');
requireCore('metadata');
requireCore('trackback');
requireCore('theme');
requireCore('feed');
requireCore('validate');
requireCore('message');
requireCore('csrf');
requireCore('cache');
requireCore('dispatcher');
?>
