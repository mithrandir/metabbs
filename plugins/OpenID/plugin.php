<?php
function openid_form() {
	return '<form method="post" action="' . url_with_referer_for('openid', 'login') . '" style="font-size: 12px">
<p><input type="text" name="openid_identifier" style="background: #fff url(' . METABBS_BASE_PATH . 'plugins/OpenID/login-bg.gif) no-repeat 0 50%; padding-left: 18px;" /> <input type="submit" value="' . i('Login') . '" /><br />
<input type="checkbox" name="autologin" value="1" id="openid_autologin" /> <label for="openid_autologin">'.i('Auto Login').'</label></p>
</form>';
}
class OpenID extends Plugin {
	var $description = 'OpenID로 로그인합니다.';
	function add_include_path() {
		ini_set("include_path", dirname(__FILE__) . PATH_SEPARATOR . ini_get("include_path"));
	}
	function on_init() {
		global $account, $controller, $action, $layout;
		$this->add_include_path();
		add_filter('LinkToLogin', array(&$this, 'at_login_link'), 50);
		add_filter('AfterLogout', array(&$this, 'unset_cookie'), 50);
		if ($account->is_guest()) {
			if (cookie_is_registered('openid') && $controller != 'openid') {
				redirect_to(url_with_referer_for('openid', 'login').'&openid_identifier='.urlencode(cookie_get('openid')));
			}
			if ($controller != 'account' && $action != 'login') {
				$layout->header .= openid_form();
			}
		}
	}
	function on_settings() {
		if (is_post()) {
			$this->set_attribute('flite_path', 1);
		}

	}
	function at_login_link(&$link, $board) {
		$link = link_text(url_with_referer_for('openid', 'login'), i('Login'), array('id' => null));
	}
	function unset_cookie() {
		cookie_unregister('openid');
	}
}

register_plugin('OpenID');
?>
