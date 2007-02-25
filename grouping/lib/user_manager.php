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
		if (session_is_registered('user_id')) {
			$user = User::find($_SESSION['user_id']);
			if ($user->exists()) return $user;
		} else {
			if (cookie_is_registered('user_id') && cookie_is_registered('token')) {
				$user = User::find(cookie_get('user_id'));
				if ($user->token == cookie_get('token')) {
					$_SESSION['user_id'] = $user->id;
					return $user;
				} else {
					return null;
				}
			}
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
			$_SESSION['user_id'] = $user->id;
			if ($autologin) {
				cookie_register('user_id', $user->id);
				$token = md5(microtime() . uniqid(rand(), true));
				cookie_register('token', $token);
				$user->set_token($token);
			} else {
				cookie_unregister('user_id');
				cookie_unregister('token');
				$user->unset_token();
			}
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
		$user = UserManager::get_user();
		if ($user) {
			session_destroy();
			cookie_unregister('user_id');
			cookie_unregister('token');
			$user->unset_token();
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
