<?php
if (!isset($_GET['code']) || !isset($_GET['id']) || empty($_GET['code']) || empty($_GET['id'])) {
	print_notice('Invalid Request.', 'This Page is not Available');
	exit;
}

$user = User::find($_GET['id']);
if (!is_null($user->id)) {
	$code = $user->get_attribute('pwresetcode');

	if (!empty($code) && $_GET['code'] == $code) {
		if (is_post()) {
			$user->password = md5($_POST['password']);
			$user->update();

			$user->remove_attribute('pwresetcode');
			redirect_to(url_for('account', 'login', array('url'=> urlencode(METABBS_HOST_URL))));
		}
	} else
		$error = i('The Code does not matched').".";

} else
	$error = i('Your account does not exist').".";
