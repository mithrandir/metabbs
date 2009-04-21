<?php
$layout->title = i('OpenID Edit');
$openids = Openid::find_all();
include 'themes/'.get_current_theme().'/account-openid.php';
?>
