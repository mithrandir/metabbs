<?php
if (!$account->is_admin())
	access_denied();

$user = User::find($id);
$code = $user->get_attribute('pwresetcode');
if (!$code) {
	$code = md5(microtime() . uniqid(rand(), true));
	$user->set_attribute('pwresetcode', $code);
	$already_reset = false;
} else {
	$already_reset = true;
}
$reset_url = full_url_for('account', 'reset-password').'?id='.$user->id.'&code='.$code;

$view = ADMIN_VIEW;
