<?php
header("Content-Type: text/html; charset=utf-8");

// pre-define METABBS_BASE_PATH
$path = dirname($_SERVER['SCRIPT_NAME']);
if ($path == '\\' || $path == '/') $path = '';
$metabbs_base_path = $path . '/';

if (!defined('METABBS_DIR')) {
	define('METABBS_DIR', realpath(dirname(__FILE__) . '/..'));
}

if (!file_exists(METABBS_DIR . '/metabbs.conf.php')) {
	echo '<h1>Config file not found.</h1><p>Did you install metaBBS? :) <a href="' . $metabbs_base_path . 'install.php">Go to install page &raquo;</a></p>';
	exit;
}

if (!defined('METABBS_HOST_URL')) {
	define('METABBS_HOST_URL', ($_SERVER['SERVER_PORT'] != 443 ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . ($_SERVER['SERVER_PORT'] != 80 && $_SERVER['SERVER_PORT'] != 443 ? ':' . $_SERVER['SERVER_PORT'] : ''));
}

ini_set('include_path', METABBS_DIR . PATH_SEPARATOR . ini_get('include_path'));

require METABBS_DIR . '/cores/compat.php';
require METABBS_DIR . '/cores/core.php';
require METABBS_DIR . '/cores/permission.php';
require METABBS_DIR . '/cores/request.php';
require METABBS_DIR . '/cores/i18n.php';
require METABBS_DIR . '/cores/cookie.php';
require METABBS_DIR . '/cores/tag_helper.php';
require METABBS_DIR . '/cores/plugin.php';
require METABBS_DIR . '/cores/metadata.php';
require METABBS_DIR . '/cores/trackback.php';
require METABBS_DIR . '/cores/theme.php';
require METABBS_DIR . '/cores/captcha.php';
require METABBS_DIR . '/cores/feed.php';
require METABBS_DIR . '/cores/validate.php';
require METABBS_DIR . '/cores/message.php';

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
