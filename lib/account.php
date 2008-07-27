<?php
/**
 * 화면 상단의 계정 콘트롤 부분을 가져온다.
 * 로그인 / 가입 또는 로그아웃 / 회원정보 수정은 이 함수가 담당한다.
 * @param $account 회원 계정 인스턴스
 * @return 화면에 구성할 콘트롤 부분의 집합
 */
function get_account_control($account) {
	if (!$account || $account->is_guest()) {
		return array(login(), signup());
	} else if ($account->is_admin()) {
		return array(logout(), editinfo(), admin());
	} else {
		return array(logout(), editinfo());
	}
}

/**
 * 계정 관련 링크를 만든다.
 * @param $text 출력할 문자열
 * @param $action 해당 액션
 * @param $id 아이디
 * @return 생성된 링크 문자열
 */
function link_to_account($text, $action, $id, $controller = 'account') {
	return link_text(url_with_referer_for($controller, $action), $text, array('id' => $id));
}

/**
 * 관리자용 링크를 구성한다.
 * @return 관리자 링크
 */
function admin() {
	return link_text(url_for('admin'), i('Admin'), array('id' => 'link-admin'));
}

/**
 * 로그인 링크를 구성한다.
 * @return 로그인 링크
 */
function login() {
	global $board;
	return link_to_account(i('Login'), 'login', 'link-login');
}

/**
 * 로그아웃 링크를 구성한다.
 * @return 로그아웃 링크
 */
function logout() {
	return link_to_account(i('Logout'), 'logout', 'link-logout');
}

/**
 * 가입 링크를 구성한다.
 * @return 가입 링크
 */
function signup() {
	return link_to_account(i('Sign up'), 'signup', 'link-signup');
}

/**
 * 회원 정보 수정 링크를 구성한다.
 * @return 회원 정보 수정 링크
 */
function editinfo() {
	return link_to_account(i('Edit Info'), 'edit', 'link-editinfo');
}

/**
 * 접근 불가 메시지를 출력하거나 로그인을 시킨다.
 */
function access_denied() {
	global $account;
	header('HTTP/1.1 403 Forbidden');
	print_notice(i('Access denied'), i('You have no permission to access this page.') . ' ' . ($account->is_guest() ? login() : ''));
}

function login_required() {
	global $account;
	if ($account->is_guest()) {
		header('HTTP/1.1 403 Forbidden');
		print_notice(i('Access denied'), i('Please login to access this page.') . ' ' . ($account->is_guest() ? login() : ''));
	}
}

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
		if ($user->exists() && !$user->get_attribute('pwresetcode')) {
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
}
?>
