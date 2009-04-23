<?php
login_required();

if (!(using_openid() && $account->is_openid_account())) {
	redirect_back();
}

if (is_post()) {
	$info = $_POST['user'];
	$user = New User($info);
	$user->validate_before_transfer($error_messages);

	if(!$error_messages->exists()) {
		$openid = new Openid;
		$openid->openid = $account->user;

		$account->import($info);
		$account->password = md5($account->password);

		$openid->user_id = $account->id;

		$account->update();
		$openid->create();
		Flash::set('Transfer done');
		redirect_back();
	}
} else
	$user = New User;
?>