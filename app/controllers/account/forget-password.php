<?php
if(!$config->get('use_forget_password', false)) {
	print_notice('Invalid Request.', 'This Page is not Available');
	exit;
}

if (is_post()) {
	$user = User::find_by_user($_POST['user']);
	if ($user->exists()) {
		if ($user->get_attribute('pwresetcode')) {
			if (!empty($user->email)) {
				if ($user->name == trim($_POST['name'])) {
					$code = md5(microtime() . uniqid(rand(), true));
					$user->set_attribute('pwresetcode', $code);

					$url = METABBS_HOST_URL.url_for('account','reset-password').'?id='.$user->id.'&code='.$code;
					$message = "다음 링크 '<a href=\"".$url."\" onclick=\"window.open(this.href); return false;\">비밀번호 초기화</a>'를 클릭해서 비밀번호를 변경하시길 바랍니다.";
					sendmail_utf8('metabbs@'.$_SERVER['SERVER_NAME'], "MetaBBS", $user->email, $user->name, 'MetaBBS - '.i("Reset Password"), $message);

					Flash::set('Reset password was sent by e-mail');
				} else
					$error_messages->add('Your account\'s Name is incorrect', 'name');
			} else
				$error_messages->add('Your e-mail account is empty');
		}
	} else
		$error_messages->add('Your account does not exist', 'user');
}
?>