<?php
function get_account_control($account) {
	if ($account->is_guest()) {
		return array(login(), signup());
	} else if ($account->is_admin()) {
		return array(logout(), editinfo(), admin());
	} else {
		return array(logout(), editinfo());
	}
}

function admin() {
	return link_text(url_for('admin'), i('Admin'), array('id' => 'link-admin'));
}
function login() {
	return link_text(url_with_referer_for('account', 'login'), i('Login'), array('id' => 'link-login'));
}
function logout() {
	return link_text(url_with_referer_for('account', 'logout'), i('Logout'), array('id' => 'link-logout'));
}
function signup() {
	return link_text(url_with_referer_for('account', 'signup'), i('Sign Up'), array('id' => 'link-signup'));
}
function editinfo() {
	return link_text(url_with_referer_for('account', 'edit'), i('Edit Info'), array('id' => 'link-editinfo'));
}

function access_denied() {
	global $account;
	if ($account->is_guest()) {
		redirect_to(url_with_referer_for('account', 'login'));
	} else {
		print_notice('Access denied', 'You have no permission to access this page.');
	}
}
?>
