<?php
if (is_post()) {
	$user = new User($_POST['user']);
	$user->password = md5($user->password);
	if ($user->valid()) {
		$user->save();
		redirect_back();
	} else {
		$user = new Guest($_POST['user']);
		$user->user = $user->password = "";
		$flash = "User ID already exists.";
	}
}
?>
