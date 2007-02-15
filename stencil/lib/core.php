<?php
require 'config.php';
$config = new Config('metabbs.conf.php');

$backend = $config->get('backend', 'mysql');

/**
 * 테이블의 프리픽스
 */
define('METABBS_TABLE_PREFIX', $config->get('prefix', 'meta_'));

require 'model.php';
require 'backends/' . $backend . '/backend.php';
require 'model/board.php';
require 'model/category.php';
require 'model/post.php';
require 'model/comment.php';
require 'model/trackback.php';
require 'model/attachment.php';
require 'model/user.php';
require 'model/plugin.php';

require 'template.php';
require 'uri_manager.php';
require 'account.php';
?>
