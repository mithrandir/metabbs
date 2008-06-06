<?php
login_required();

if (is_post()) {
	$old_password = $account->password;	
	$account->import($_POST['user']);
	if (!$account->password)
		$account->password = $old_password;
	else
		$account->password = md5($account->password);
	$account->update();
	redirect_back();
}
?>
