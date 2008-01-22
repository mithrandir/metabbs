<?php
header("Content-Type: text/html; charset=utf-8");

if (!defined('METABBS_BASE_PATH')) {
	$path = dirname($_SERVER['SCRIPT_NAME']);
	if ($path == '\\' || $path == '/') $path = '';
	define('METABBS_BASE_PATH', $path . '/');
}

if (!defined('METABBS_DIR')) {
	define('METABBS_DIR', realpath(dirname(__FILE__) . '/..'));
}

if (!file_exists(METABBS_DIR . '/metabbs.conf.php')) {
	echo '<h1>Config file not found.</h1><p>Did you install metaBBS? :) <a href="' . METABBS_BASE_PATH . 'install.php">Go to install page &raquo;</a></p>';
	exit;
}

ini_set('include_path', METABBS_DIR . PATH_SEPARATOR . ini_get('include_path'));

require METABBS_DIR . '/lib/compat.php';
require METABBS_DIR . '/lib/core.php';
require METABBS_DIR . '/lib/permission.php';
require METABBS_DIR . '/lib/request.php';
require METABBS_DIR . '/lib/i18n.php';
require METABBS_DIR . '/lib/cookie.php';
require METABBS_DIR . '/lib/tag_helper.php';
require METABBS_DIR . '/lib/plugin.php';
require METABBS_DIR . '/lib/metadata.php';
require METABBS_DIR . '/lib/trackback.php';

import_default_language();

$session_dir = METABBS_DIR . '/data/session';
if (!file_exists($session_dir)) {
	mkdir($session_dir, 0707);
}
session_save_path($session_dir);
session_start();

$account = UserManager::get_user();
if (!$account) { 
	$account = new Guest;
	$guest = true;
} else {
	$guest = false;
}
$admin = $account->is_admin();

$tz = $config->get('timezone');
if ($tz) Timezone::set($tz);
?>
