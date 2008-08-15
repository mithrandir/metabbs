<?php
if (is_xhr() && isset($_GET['user'])) {
	$user = User::find_by_user($_GET['user']);
	if ($user->exists()) {
		echo '이미 사용중인 아이디입니다.';
	} else {
		echo '사용할 수 있는 아이디입니다.';
	}
	exit;
}

if($config->get('captcha_name', false) != "none" && $guest)
	$captcha = new Captcha($config->get('captcha_name', false), $captcha_arg);

if (is_post()) {
	$info = $_POST['user'];
	if (strlen($info['password']) < 5) {
		$account = new Guest($info);
		$account->password = "";
		$flash = "Password length must be longer than 5";
		$error_field = 'password';
	} else if ($info['password'] != $info['password_again']) {
		$account = new Guest($info);
		$account->password = "";
		$flash = "Two password fields' content must be same";
		$error_field = 'password';
	} else {
		$account = new User($info);
		$account->password = md5($account->password);

		if (isset($captcha) && $captcha->ready() && $captcha->is_valid($_POST) 
			|| isset($captcha) && !$captcha->ready() 
			|| !isset($captcha))  {
			if ($account->valid()) {
				$account->create();
				redirect_to(url_with_referer_for('account', 'login'));
			} else {
				$account = new Guest($info);
				$account->user = $account->password = "";
				$flash = "User ID already exists";
				$error_field = 'user';
			}
		} else {
			$flash = $captcha->error;
			$error_field = 'captcha';
		}
	}
	if(!empty($flash)) 
		$flash = i($flash) . '.';
} else {
	$account->name = '';
}
?>
