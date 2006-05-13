<?php
function admin() {
	return link_text(get_base_path(). 'admin.php', 'Admin');
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
?>
