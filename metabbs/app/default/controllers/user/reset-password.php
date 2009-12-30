<?php
if (!isset($params['code']) || !isset($params['id']) || empty($params['code']) || empty($params['id'])) {
	print_notice('Invalid Request.', 'This Page is not Available');
	exit;
}

$user = User::find($params['id']);
if ($user->exists()) {
	$code = $user->get_attribute('pwresetcode');
	if (isset($code) && $params['code'] == $code) {
		if (is_post()) {
			if (strlen($_POST['password']) < 5)
				$error_messages->add('Password length must be longer than 5', 'password');
			
			if ($_POST['password'] != $_POST['password_again'])
				$error_messages->add('Two password fields\' content must be same', 'password_again');

			if(!$error_messages->exists()) {
				$user->password = md5($_POST['password']);
				$user->update();

				$user->remove_attribute('pwresetcode');
				redirect_to(url_for('account', 'login', array('url'=> urlencode(METABBS_HOST_URL))));
			}
		}
	} else
		$error_messages->add('The Code does not matched');

} else
	$error_messages->add('Your account does not exist');
