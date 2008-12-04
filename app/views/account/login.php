<?php
$layout->title = i('Login');
$theme = new Theme('login');
$template = $theme->get_template('login');
include 'themes/'.get_current_theme().'/login.php';
?>
