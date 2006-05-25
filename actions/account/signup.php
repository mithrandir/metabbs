<?php
if (is_post()) {
	$info = $_POST['user'];
	if (strlen($info['password']) < 5) {
		print_r($info);
		$user = new Guest($info);
		$user->password = "";
		$flash = "Password length must be longer than 5";
	} else {
		$user = UserManager::signup($info['user'], $info['password'], $info['name'], $info['email'], $info['url']);
		if (!$user) {
			$user = new Guest($info);
			$user->user = $user->password = "";
			$flash = "User ID already exists.";
		} else {
			redirect_back();
		}
	}
} else {
	$user->name = "";
}
render('account/signup');
?>
