<?php
/**
 * 사용자 계정을 관리
 */
class UserManager
{
	/**
	 * 사용자 객체를 반환한다.
	 * @return 쿠키에 로그인 정보가 있는 경우 해당 사용자 객체를 반환 없는 경우 null 반환.
	 */
	function get_user() {
		if (cookie_is_registered('user') && cookie_is_registered('password')) {
			return User::auth(cookie_get('user'), cookie_get('password'));
		} else {
			return null;
		}
	}

	/**
	 * 로그인한다.
	 * @param $user 사용자 아이디
	 * @param $password 사용자 암호
	 * @param $autologin 자동 로그인
	 * @return 로그인 성공 여부를 참과 거짓으로 리턴.
	 */
	function login($user, $password, $autologin) {
		$user = User::auth($user, md5($password));
		if ($user->exists()) {
			cookie_register("user", $user->user, !$autologin);
			cookie_register("password", $user->password, !$autologin);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 로그 아웃한다.
	 * @return 성공, 실패 여부를 참과 거짓으로 반환.
	 */
	function logout() {
		if (UserManager::get_user()) {
			cookie_unregister('user');
			cookie_unregister('password');
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 가입한다.
	 * @param $user_id 사용자 아이디
	 * @param $password 사용자 암호
	 * @param $name 사용자 이름
	 * @param $email 이메일 주소
	 * @param $url 사이트 url
	 * @return 성공했을 경우 유저 객체를 실패한 경우 null을 반환.
	 */
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
?>
