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

function requireCore($name) {
	global $_requireCore;
	if(!in_array($name,$_requireCore)) {
		include_once (METABBS_DIR . "/core/$name.php");
		array_push($_requireCore,$name);
	}
}
function requireModel($name) {
	global $_requireModels;
	if(!in_array($name,$_requireModels)) {
		include_once (METABBS_DIR . "/app/models/$name.php");
		array_push($_requireModels,$name);
	}
}
function requireExternel($name) {
	global $_requireExternel;
	if(!in_array($name,$_requireExternel)) {
		include_once (METABBS_DIR . "/core/external/$name.php");
		array_push($_requireExternel,$name);
	}
}

$_requireCore = array(
	'compat',
	'core',
	'permission',
	'request',
	'i18n',
	'cookie',
	'tag_helper',
	'plugin',
	'metadata',
	'trackback',
	'theme',
	'feed',
	'validate',
	'message',
	'csrf'
);
$_requireModels = $_requireExternel = array();
foreach($_requireCore as $name) {
	require METABBS_DIR .'/core/'.$name.'.php';
}
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

$error_messages = new Notice();
?>
