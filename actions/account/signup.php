<?php
if (is_post()) {
	$info = $_POST['user'];
	if (strlen($info['password']) < 5) {
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
render('signup');

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
