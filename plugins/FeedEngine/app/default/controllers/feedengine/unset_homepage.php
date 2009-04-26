<?php
login_required();
$account->url = '';
$account->update();
if(is_xhr()) {
	include 'themes/'.get_current_theme().'/_homepage.php';
	exit;
} else
	redirect_back();
?>