<?php
function admin() {
	return link_text(get_base_path(). 'admin.php', 'Admin');
}

function login() {
	return link_text(url_with_referer_for('user', 'login'), 'Login');
}

function logout() {
	return link_text(url_with_referer_for('user', 'logout'), 'Logout');
}

function signup() {
	return link_text(url_with_referer_for('user', 'signup'), 'Sign Up');
}

function editinfo() {
	return link_text(url_with_referer_for('user', 'edit'), 'Edit Info');
}
?>
