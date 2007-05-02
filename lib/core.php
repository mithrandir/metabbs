<?php
require METABBS_DIR . '/lib/config.php';
$config = new Config('metabbs.conf.php');

$backend = $config->get('backend', 'mysql');

/**
 * 테이블의 프리픽스
 */
define('METABBS_TABLE_PREFIX', $config->get('prefix', 'meta_'));

require METABBS_DIR . '/lib/model.php';
require METABBS_DIR . '/lib/backends/' . $backend . '/backend.php';
require METABBS_DIR . '/app/models/board.php';
require METABBS_DIR . '/app/models/category.php';
require METABBS_DIR . '/app/models/post.php';
require METABBS_DIR . '/app/models/comment.php';
require METABBS_DIR . '/app/models/trackback.php';
require METABBS_DIR . '/app/models/attachment.php';
require METABBS_DIR . '/app/models/user.php';
require METABBS_DIR . '/app/models/plugin.php';

require METABBS_DIR . '/lib/template.php';
require METABBS_DIR . '/lib/uri_manager.php';
require METABBS_DIR . '/lib/account.php';
require METABBS_DIR . '/lib/timezone.php';
?>
