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

function link_to_account($text, $action, $id) {
	global $board;
	$controller = $action == 'login' && isset($board) ? $board : 'account';
	return link_text(url_with_referer_for($controller, $action), $text, array('id' => $id));
}
function admin() {
	return link_text(url_for('admin'), i('Admin'), array('id' => 'link-admin'));
}
function login() {
	return link_to_account(i('Login'), 'login', 'link-login');
}
function logout() {
	return link_to_account(i('Logout'), 'logout', 'link-logout');
}
function signup() {
	return link_to_account(i('Sign Up'), 'signup', 'link-signup');
}
function editinfo() {
	return link_to_account(i('Edit Info'), 'edit', 'link-editinfo');
}

function access_denied() {
	global $account;
	if ($account->is_guest()) {
		redirect_to(url_with_referer_for('account', 'login'));
	} else {
		print_notice('Access denied', 'You have no permission to access this page.');
	}
}

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
