<?php
if (is_post()) {
	$info = $_POST['user'];
	$user = UserManager::signup($info['user'], $info['password'], $info['name'], $info['email'], $info['url']);
	if (!$user) {
		$user = new Guest($_POST['user']);
		$user->user = $user->password = "";
		$flash = "User ID already exists.";
	} else {
		redirect_back();
	}
}
?>
