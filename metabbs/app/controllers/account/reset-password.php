<?php
if (!isset($_GET['code']) || !isset($_GET['id']))
	exit; // invalid request, so just ignore

$user = User::find($_GET['id']);
$code = $user->get_attribute('pwresetcode');
if (!$code || $_GET['code'] != $code)
	$error = true;
else
	$error = false;

if (is_post()) {
	if ($error) exit;

	$user->password = md5($_POST['password']);
	$user->update();

	$user->remove_attribute('pwresetcode');
	redirect_to(url_for('account', 'login'));
}
