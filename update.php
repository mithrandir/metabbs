<?php
require_once("lib/core.php");
$conn = get_conn();
if (isset($_GET['rev']) && is_numeric($_GET['rev'])) {
    include("db/update_$_GET[rev].php");
    echo "updated to revision $_GET[rev]";
}
?>
