 <?php
/*if ($account->is_openid_account()) {
	Flash::set('You didn\'t have OpenID-Account');
}*/
 
if (isset($_REQUEST['openid_identifier'])) {
	$openid = $_REQUEST['openid_identifier'];
	if (isset($_POST['autologin'])) {
		cookie_register('openid', $openid);
	}
	$auth_request = $consumer->begin($openid);
	if ($auth_request) {
		redirect_to($auth_request->redirectURL(METABBS_HOST_URL . METABBS_BASE_PATH, full_url_for('openid', 'register_complete').'?url='.$_GET['url']));
	} else {
		Flash::set('OpenID\'s not ready');
	}
}
exit;
?>
