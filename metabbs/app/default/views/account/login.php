<?php
$layout->title = i('Login');
$theme = new Theme('login');
/* DEBUG */
//$template = $theme->get_template('login');
//$template->render();
include 'themes/'.get_current_theme().'/login.php';
?>
