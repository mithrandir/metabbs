<?php
if (is_post()) {
	$info = $_POST['user'];
	if (strlen($info['password']) < 5) {
		print_r($info);
		$account = new Guest($info);
		$account->password = "";
		$flash = "Password length must be longer than 5";
	} else {
		$account = UserManager::signup($info['user'], $info['password'], $info['name'], $info['email'], $info['url']);
		if (!$account) {
			$account = new Guest($info);
			$account->user = $account->password = "";
			$flash = "User ID already exists.";
		} else {
			redirect_back();
		}
	}
} else {
	$account->name = "";
}
render('account/signup');
?>
