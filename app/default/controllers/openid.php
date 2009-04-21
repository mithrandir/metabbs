<?php
if (!using_openid())
	print_notice('OpenID support disabled.', 'This site does not allow you to login with OpenID.');

if (!file_exists('/dev/urandom')) {
	define('Auth_OpenID_RAND_SOURCE', NULL);
}
define('Auth_OpenID_NO_MATH_SUPPORT', 1);

ini_set("include_path", 'core/external/php-openid' . PATH_SEPARATOR . ini_get("include_path"));

require_once 'Auth/OpenID.php';
require_once 'Auth/OpenID/Consumer.php';
require_once 'Auth/OpenID/FileStore.php';

$store_path = METABBS_DIR . '/data/openid';

if (!file_exists($store_path) && !mkdir($store_path)) {
	print_notice('Cannot create OpenID store directory.', 'Please check the permission of ' . METABBS_DIR . '/data.');
}

$store = new Auth_OpenID_FileStore($store_path);
$consumer = new Auth_OpenID_Consumer($store);
?>
