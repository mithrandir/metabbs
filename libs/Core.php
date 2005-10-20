<?php

define("METABBS_VERSION", "0.1");

function error($msg) {
    print "<p>$msg</p>";
    exit;
}
function redirect_to($url) {
    if (!headers_sent()) {
        header("Location: $url");
    } else {
        $url = htmlspecialchars($url);
        print "<meta http-equiv=\"refresh\" content=\"0;url=$url\" />";
    }
    exit;
}

@import_request_variables('gpc');

@include 'config.php';

?>
