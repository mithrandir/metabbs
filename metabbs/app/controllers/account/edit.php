<?php
login_required();

if (is_post()) {
	$info = $_POST['user'];
	apply_filters('beforeAccountEdit', $info);

	$old_password = $account->password;	
	$account->import($info);

	// validate
	if (strlen($account->password) < 5) {
		$account->password = "";
		$flash = "Password length must be longer than 5";
		$error_field = 'password';
	} else if (!empty($info['email']) && !preg_match("(^[_0-9a-zA-Z-.]+@[0-9a-zA-Z-]+(.[_0-9a-zA-Z-]+)*$)", $info['email'])) {
		$account->password = "";
		$flash = "Please enter a valid 'Your E-Mail Address'";
		$error_field = 'email';
	} else {
		if (!$account->password)
			$account->password = $old_password;
		else
			$account->password = md5($account->password);
		$account->update();
		redirect_back();
	}
	if(!empty($flash)) 
		$flash = i($flash) . '.';
}
?>
