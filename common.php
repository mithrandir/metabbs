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

$metabbs_dir = dirname(__FILE__) . '/';

require_once $metabbs_dir . 'config.php';
$config = new Config($metabbs_dir . 'metabbs.conf.php');

$backend = $config->get('backend');
if (!$backend) $backend = 'mysql';

$lib_dir = $metabbs_dir . 'model';
require_once $lib_dir . '/Model.php';
require_once 'backends/' . $backend . '/backend.php';
require_once $lib_dir . '/Board.php';

if (session_is_registered('user_id')) {
    $user = User::find($_SESSION['user_id']);
    if (!$user->exists()) {
        unset($user);
    }
}
if (!isset($user)) {
    $user = new Guest;
}

require_once 'template.php';
require_once 'uri_manager.php';
require_once 'page.php';

function is_admin() {
    global $user;
    return ($user->level == 255);
}
?>
