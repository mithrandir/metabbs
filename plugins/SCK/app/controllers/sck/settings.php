<?php
if (is_post()) {
	$config->set('sck_site_name', $_POST['site_name']);
	$config->write_to_file();
	sck_stylesheet_write($_POST['css']);
}
