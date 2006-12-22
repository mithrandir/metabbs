<?php
define('METABBS_DB_REVISION', 650);

require 'config.php';
$config = new Config('metabbs.conf.php');

$backend = $config->get('backend', 'mysql');
define('METABBS_TABLE_PREFIX', $config->get('prefix', 'meta_'));

if (@ini_get('magic_quotes_runtime'))
	set_magic_quotes_runtime(0);

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
