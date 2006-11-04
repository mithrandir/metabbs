<?php
class UserManager
{
	function get_user() {
		if (cookie_is_registered('user') && cookie_is_registered('password')) {
			return User::auth(cookie_get('user'), cookie_get('password'));
		} else {
			return null;
		}
	}
	function login($user, $password) {
		$user = User::auth($user, md5($password));
		if ($user->exists()) {
			cookie_register("user", $user->user);
			cookie_register("password", $user->password);
			return true;
		} else {
			return false;
		}
	}
	function logout() {
		if (UserManager::get_user()) {
			cookie_unregister('user');
			cookie_unregister('password');
			return true;
		} else {
			return false;
		}
	}
	function signup($user_id, $password, $name, $email, $url) {
		$user = new User;
		$user->user = $user_id;
		$user->password = md5($password);
		$user->name = $name;
		$user->email = $email;
		$user->url = $url;

		if ($user->valid()) {
			$user->create();
			return $user;
		} else {
			return null;
		}
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
