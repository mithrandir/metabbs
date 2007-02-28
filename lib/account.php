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
function link_to_account($text, $action, $id) {
	global $board;
	$controller = $action == 'login' && isset($board) ? $board : 'account';
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
	if ($account->is_guest()) {
		redirect_to(url_with_referer_for('account', 'login'));
	} else {
		print_notice('Access denied', 'You have no permission to access this page.');
	}
}
?>
