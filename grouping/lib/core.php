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
require 'app/models/board.php';
require 'app/models/category.php';
require 'app/models/post.php';
require 'app/models/comment.php';
require 'app/models/trackback.php';
require 'app/models/attachment.php';
require 'app/models/user.php';
require 'app/models/plugin.php';
require 'app/models/group.php';
require 'app/models/permission.php';

require 'template.php';
require 'uri_manager.php';
require 'account.php';
?>
