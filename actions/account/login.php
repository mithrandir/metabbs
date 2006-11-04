<?php
if (is_post()) {
	$account = UserManager::login($_POST['user'], $_POST['password']);
	if (!$account) {
		$account = new Guest;
		$flash = 'Login failed.';
	} else {
		redirect_back();
	}
}
render('login');

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
