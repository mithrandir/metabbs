<?php
$layout->title = i('Transfer to Default Account');
$openids = Openid::find_all();
include 'themes/'.get_current_theme().'/account-transfer.php';
?>