<?php
header("Content-Type: text/html; charset=utf-8");

if (@ini_get('register_globals')) {
    foreach ($_REQUEST as $k => $v) {
        unset($$k);
    }
}

//$metabbs_dir = dirname(__FILE__) . '/../';

require_once("core.php");

if (cookie_is_registered('user') && cookie_is_registered('password')) {
    $user = User::auth(cookie_get('user'), cookie_get('password'));
    if (!$user->exists()) {
        unset($user);
    }
}
if (!isset($user)) {
    $user = new Guest;
}

function cookie_get($name) {
    if (cookie_is_registered($name)) {
        return $_COOKIE["metabbs_$name"];
    }
}
function cookie_is_registered($name) {
    return isset($_COOKIE["metabbs_$name"]);
}
function cookie_register($name, $value) {
    setcookie("metabbs_$name", $value, time() + 60*60*24*30, get_base_path());
}
function cookie_unregister($name) {
    setcookie("metabbs_$name", "", time() - 3600, get_base_path());
}

function is_admin() {
    global $user;
    return ($user->level == 255);
}
?>
