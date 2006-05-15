<?php
header("Content-Type: text/html; charset=utf-8");

if (@ini_get('register_globals')) {
    foreach ($_REQUEST as $k => $v) {
        unset($$k);
    }
}

if (file_exists('data/session')) {
    session_save_path('data/session');
    session_start();
}

require_once 'config.php';
$config = new Config('metabbs.conf.php');

$backend = $config->get('backend');
if (!$backend) $backend = 'mysql';

$lib_dir = 'backends/common';
require_once $lib_dir . '/Model.php';
require_once 'backends/' . $backend . '/' . $backend . '.php';
require_once $lib_dir . '/Board.php';

require_once 'template.php';
require_once 'uri_manager.php';
require_once 'page.php';

function is_admin() {
    global $config;
    return session_is_registered('admin_password') &&
        $config->get('admin_password') == $_SESSION['admin_password'];
}
?>
