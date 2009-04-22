<?php
$response = $consumer->complete($_GET);

if ($response->status == Auth_OpenID_SUCCESS) {
	$openid = Openid::find_by_openid($response->identity_url);
	$user = User::find_by_user($response->identity_url);
	if (!$openid->exists() and !$user->exists()) {
		$openid = new Openid;
		$openid->openid = $response->identity_url;
		$openid->user_id = $account->id;
		if(!$error_messages->exists()) {
			$openid->create();
		}
	} else {
		Flash::set('OpenID is duplicated');
	}
} else if ($response->status == Auth_OpenID_CANCEL) {
	Flash::set('Verification cancelled');
} else {
	Flash::set($response->message);
}
redirect_back();
?>