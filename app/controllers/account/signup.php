<?php
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
		$account = UserManager::signup($info['user'], $info['password'], $info['name'], $info['email'], $info['url']);
		if (!$account) {
			$account = new Guest($info);
			$account->user = $account->password = "";
			$flash = "User ID already exists";
			$error_field = 'user';
		} else {
			redirect_back();
		}
	}
	$flash = i($flash) . '.';
} else {
	$account->name = '';
}
?>
