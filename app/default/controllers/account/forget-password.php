<?php
if(!$config->get('use_forget_password', false)) {
	print_notice('Invalid Request.', 'This Page is not Available');
	exit;
}

if (is_post()) {
	$user = User::find_by_user($params['user']);
	if ($user->exists()) {
		if ($user->get_attribute('pwresetcode')) {
			if (!empty($user->email)) {
				if ($user->name == trim($params['name'])) {
					$code = md5(microtime() . uniqid(rand(), true));
					$user->set_attribute('pwresetcode', $code);

					$url = full_url_for($user,'reset-password', array('code' => $code));
					$message = "다음 링크 '<a href=\"".$url."\" onclick=\"window.open(this.href); return false;\">비밀번호 초기화</a>'를 클릭해서 비밀번호를 변경하시길 바랍니다.";
					sendmail_utf8('metabbs@'.$_SERVER['SERVER_NAME'], "MetaBBS", $user->email, $user->name, 'MetaBBS - '.i("Reset Password"), $message);

					Flash::set('Reset password was sent by e-mail');
					redirect_back();
				} else
					$error_messages->add('Your account\'s Name is incorrect', 'name');
			} else
				$error_messages->add('Your e-mail account is empty');
		} else
			Flash::set('You already reset password');
	} else
		$error_messages->add('Your account does not exist', 'user');
}
?>