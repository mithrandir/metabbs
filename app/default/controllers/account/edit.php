<?php
login_required();

if (is_post()) {
	$info = $_POST['user'];
	apply_filters('beforeAccountEdit', $info);

	$old_password = $account->password;	
	$account->import($info);
	$account->validate_before_update($error_messages);

	if(!$error_messages->exists()) {
		if (!$account->password)
			$account->password = $old_password;
		else
			$account->password = md5($account->password);
		$account->update();
		Flash::set('Edit done');		
		redirect_back();
	} 
}
?>
