 <?php
if (isset($_REQUEST['openid_identifier']) and !empty($_REQUEST['openid_identifier'])) {
	$openid = $_REQUEST['openid_identifier'];
	if (isset($_POST['autologin'])) {
		cookie_register('openid', $openid);
	}
	$auth_request = $consumer->begin($openid);
	if ($auth_request) {
		redirect_to($auth_request->redirectURL(METABBS_HOST_URL . METABBS_BASE_PATH, full_url_for('openid', 'register_complete', array('url'=>url_with_referer_for('account','edit')))));
	} else {
		Flash::set('OpenID\'s not ready');
		// for backward compatibility
		redirect_to(url_with_referer_for('account', 'edit'));
	}
} else {
	Flash::set('OpenID field is empty');
	// for backward compatibility
	redirect_to(url_with_referer_for('account', 'edit'));
}
?>
