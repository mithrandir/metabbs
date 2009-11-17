<?php
$user = User::find($params['id']);
$code = $user->exists() ? $user->get_attribute('pwresetcode') : null;
if (is_post()) {
	if (!is_null($code)) {
		$code = md5(microtime() . uniqid(rand(), true));
		$user->set_attribute('pwresetcode', $code);
	}
}
if (empty($code)) {
	Flash::set(i('User have no reset code'));
	redirect_back();
}
$reset_url = empty($code) ? null : full_url_for($user, 'reset-password', array('code' => $code));