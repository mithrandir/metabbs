<?php
$user = User::find($params['id']);
$code = $user->get_attribute('pwresetcode');
if (!$code) {
	$code = md5(microtime() . uniqid(rand(), true));
	$user->set_attribute('pwresetcode', $code);
	$already_reset = false;
} else {
	$already_reset = true;
}
$reset_url = full_url_for($user, 'reset-password', array('code' => $code));

