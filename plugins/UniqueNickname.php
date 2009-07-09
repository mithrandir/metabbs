<?php
class UniqueNickname extends Plugin {
	var $plugin_name = '사용자 이름 중복 확인';
	var $description = '사용자 이름이 겹치지 않게 해줍니다.';

	function on_init() {
		add_filter('beforeAccountEdit', array(&$this, 'check_collision'), 50);
		add_filter('ValidateAccountSignup', array(&$this, 'check_collision'), 50);
	}

	function check_collision($params) {
		global $account, $error_messages;

		// XXX: ValidateAccountSignup 이벤트는 $_REQUEST를 넘겨줌
		// 규칙성을 위해 고쳐야 할 듯
		if (isset($params['user']))
			$params = $params['user'];

		$_user = find_by('user', 'name', $params['name']);
		if ($_user->exists() && $_user->id != $account->id)
			$error_messages->add('같은 이름이 이미 존재합니다', 'name');
	}
}

register_plugin('UniqueNickname');
