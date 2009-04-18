<?php
if (!file_exists('/dev/urandom')) {
	define('Auth_OpenID_RAND_SOURCE', NULL);
}
define('Auth_OpenID_NO_MATH_SUPPORT', 1);

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
