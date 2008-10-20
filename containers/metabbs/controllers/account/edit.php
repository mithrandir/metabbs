<?php
login_required();

if (is_post()) {
	$info = $params['user'];
	apply_filters('beforeAccountEdit', $info);

	$old_password = $account->password;	
	$account->import($info);

	// validate
	if (!empty($account->password) && strlen($account->password) < 5)
		$error_messages->add('Password length must be longer than 5', 'password');

	if (!empty($account->email) && !Validate::email($account->email))
		$error_messages->add('Please enter a valid \'Your E-Mail Address\'', 'email');

	if (!empty($account->url) && !Validate::domain($account->url))
		$error_messages->add('Please enter a valid \'Homepage Address\'', 'url');	

	if(!$error_messages->exists()) {
		if (!$account->password)
			$account->password = $old_password;
		else
			$account->password = md5($account->password);
		$account->update();

		Flash::set('Information has changed');
		redirect_back();
	} 
}
?>
