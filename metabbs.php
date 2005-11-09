<?php
header("Content-Type: text/html; charset=UTF-8");

require_once 'config.php';

$lib_dir = dirname(__FILE__) . "/backends/$backend";
require_once $lib_dir.'/'.$backend.'.php';
require_once $lib_dir.'/Board.php';
require_once 'controller.php';
require_once 'url_helper.php';

function print_flash() {
    global $flash;
    if ($flash) {
        print("<div class='flash'><p>$flash</p></div>");
    }
}

function now() {
    $t = split(' ', microtime());
    return $t[0]+$t[1];
}

function benchmark() {
    static $start;
    if (isset($start)) {
        echo now() - $start;
    } else {
        $start = now();
    }
}

benchmark();

?>
