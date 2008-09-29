<?php
if (!isset($_GET['code']) || !isset($_GET['id']) || empty($_GET['code']) || empty($_GET['id'])) {
	print_notice('Invalid Request.', 'This Page is not Available');
	exit;
}

$user = User::find($_GET['id']);
if ($user->exists()) {
	$code = $user->get_attribute('pwresetcode');

	if (!empty($code) && $_GET['code'] == $code) {
		if (is_post()) {
			if (strlen($_POST['password']) < 5)
				$error->add('Password length must be longer than 5', 'password');
			
			if ($_POST['password'] != $_POST['password_again'])
				$error->add('Two password fields\' content must be same', 'password_again');

			if(!$error->exists()) {
				$user->password = md5($_POST['password']);
				$user->update();

				$user->remove_attribute('pwresetcode');
				redirect_to(url_for('account', 'login', array('url'=> urlencode(METABBS_HOST_URL))));
			}
		}
	} else
		$error->add('The Code does not matched');

} else
	$error->add('Your account does not exist');
