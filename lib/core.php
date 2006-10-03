<?php
if (defined('E_STRICT'))
	error_reporting(E_ALL ^ E_STRICT);

require_once 'config.php';
$config = new Config('metabbs.conf.php');

$backend = $config->get('backend', 'mysql');
define('METABBS_TABLE_PREFIX', $config->get('prefix', 'meta_'));

if (@ini_get('magic_quotes_runtime'))
	set_magic_quotes_runtime(0);

require_once 'model.php';
require_once 'backends/' . $backend . '/backend.php';
require_once 'model/board.php';
require_once 'model/category.php';
require_once 'model/post.php';
require_once 'model/comment.php';
require_once 'model/trackback.php';
require_once 'model/attachment.php';
require_once 'model/user.php';

require_once 'template.php';
require_once 'uri_manager.php';
require_once 'account.php';
?>
