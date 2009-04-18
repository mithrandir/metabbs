<?php
if (isset($_REQUEST['openid_identifier'])) {
	$openid = $_REQUEST['openid_identifier'];
	if (isset($_POST['autologin'])) {
		cookie_register('openid', $openid);
	}
	$auth_request = $consumer->begin($openid);
	if ($auth_request) {
		$auth_request->addExtensionArg('sreg', 'required', 'nickname');
		$auth_request->addExtensionArg('sreg', 'optional', 'email');
		redirect_to($auth_request->redirectURL(substr(full_url_for(''), 0, -1), full_url_for('openid', 'complete').'?url='.$_GET['url']));
	} else {
		$fail = true;
	}
}
?>
