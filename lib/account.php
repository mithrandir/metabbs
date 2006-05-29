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
	return link_text(url_for('admin'), 'Admin');
}

function login() {
	return link_text(url_with_referer_for('account', 'login'), 'Login');
}

function logout() {
	return link_text(url_with_referer_for('account', 'logout'), 'Logout');
}

function signup() {
	return link_text(url_with_referer_for('account', 'signup'), 'Sign Up');
}

function editinfo() {
	return link_text(url_with_referer_for('account', 'edit'), 'Edit Info');
}

function access_denied() {
	redirect_to(url_with_referer_for('account', 'login'));
}
?>
