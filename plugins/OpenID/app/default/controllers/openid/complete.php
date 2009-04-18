<?php
$response = $consumer->complete($_GET);

if ($response->status == Auth_OpenID_SUCCESS) {
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
	$_SESSION['user_id'] = $user->id;
	redirect_back();
} else if ($response->status == Auth_OpenID_CANCEL) {
	print_notice('OpenID login failed.', 'Verification cancelled.');
} else {
	print_notice('OpenID login failed.', $response->message);
}
?>
