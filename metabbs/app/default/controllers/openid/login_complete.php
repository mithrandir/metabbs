<?php
$response = $consumer->complete($_GET);

if ($response->status == Auth_OpenID_SUCCESS) {
	$openid = Openid::find_by_openid($response->identity_url);
	if ($openid->exists()) {
		$user = $openid->get_user();
	} else {
		$user = User::find_by_user($response->identity_url);		
		if (!$user->exists()) {
			$user = new User;
			$user->user = $response->identity_url;
			$user->password = 'openid';
			$sreg = $response->extensionResponse('sreg');
			if (array_key_exists('nickname', $sreg))
				$user->name = $sreg['nickname'];
			else
				$user->name = $user->user; // fallback
			$user->email = $sreg['email'];
			$user->create();
		}
	}
	
	if ($user->exists())
		$_SESSION['user_id'] = $user->id;
		
} else if ($response->status == Auth_OpenID_CANCEL) {
	Flash::set('Verification cancelled');
} else {
	Flash::set($response->message);
}
redirect_back();
?>
