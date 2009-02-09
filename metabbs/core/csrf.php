<?php
function make_form_token() {
	$token = md5(microtime() . uniqid(rand(), true));
	$_SESSION['form_token'] = $token;
	return $token;
}

function check_form_token() {
	if (!isset($_POST['form_token']) || !isset($_SESSION['form_token'])
		|| $_POST['form_token'] != $_SESSION['form_token'])
		print_notice('CSRF attack prevention', '...');
	else
		unset($_SESSION['form_token']);
}

function form_token_field() {
	return '<input type="hidden" name="form_token" value="' . make_form_token() . '" />';
}
