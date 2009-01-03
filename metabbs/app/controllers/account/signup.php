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

$captcha = $config->get('captcha_name', false) != "none" && $guest 
	? new Captcha($config->get('captcha_name', false), $captcha_arg) : null;

if (is_post()) {
	$info = $_POST['user'];
	apply_filters('BeforeAccountSignup', $info);

	if (strlen($info['password']) < 5)
		$error_messages->add('Password length must be longer than 5', 'password');
	
	if ($info['password'] != $info['password_again'])
		$error_messages->add('Two password fields\' content must be same', 'password_again');

	if (!empty($info['email']) && !Validate::email($info['email']))
		$error_messages->add('Please enter a valid E-Mail address', 'email');

	if (!empty($info['url']) && strlen($info['url']) > 255)
		$error_messages->add('Please enter a homepage address shorter than 255 characters', 'url');

	if (!(isset($captcha) && $captcha->ready() && $captcha->is_valid($_POST) 
		|| isset($captcha) && !$captcha->ready() 
		|| !isset($captcha)))
		$error_messages->add($captcha->error, 'captcha');

	$account = new User($info);
	$account->password = md5($account->password);
	if (!$account->valid()) 
		$error_messages->add('User ID already exists', 'user');

	if(!$error_messages->exists()) {
		$account->create();
		redirect_to(url_with_referer_for('account', 'login'));
	} 
	unset($account);
	$account = new Guest($info);
	$account->password = "";

} else {
	$account->name = '';
}
?>
