<?php
function authz_require($user, $perm, $object) {
	switch ($perm) {
		case 'list':
			if ($user->level < $object->perm_read) {
				authz_reject();
			}
		break;
		case 'read':
			$board = $object->get_board();
			if ($user->level < $board->perm_read) {
				authz_reject();
			}
			if ($object->secret) {
				if ($object->user_id == 0 && $user->is_guest())
					authz_ask_password($object);
				else if ($object->user_id == $user->id || $user->is_admin())
					authz_success();
				else
					authz_reject();
			}
		break;
		case 'write':
			if ($user->level < $object->perm_write) {
				authz_reject();
			} else {
				authz_success();
			}
		break;
		case 'delete':
			$board = $object->get_board();
			if ($object->user_id == 0 && $user->is_guest()) {
				authz_ask_password($object);
			} else if ($user->id == $object->user_id || $user->level >= $board->perm_delete || $user->is_admin()) {
				authz_success();
			} else {
				authz_reject();
			}
		break;
		case 'edit':
			$board = $object->get_board();
			if (isset($object->secret) && $object->secret && $object->user_id == 0 && $user->is_guest()) {
				authz_ask_password($object);
			} else if ($user->id == $object->user_id || $user->level >= $board->perm_delete || $user->is_admin()) {
				// XXX: 익명 사용자 글이라도 일단 허용한다.
				authz_success();
			} else {
				authz_reject();
			}
		break;
		case 'comment':
			$board = $object->get_board();
			if ($user->level < $board->perm_comment) {
				authz_reject();
			} else {
				authz_success();
			}
		break;
	}
}

function authz_reject() {
	access_denied();
}
function authz_success() {
	// do nothing
}
function authz_ask_password($object, $retry = false) {
	global $account;
	if (!$retry && is_post() && isset($_POST['_auth_password']) && $account->is_guest()) {
		$account->password = md5($_POST['_auth_password']);
		if ($account->password == $object->password) {
			authz_success();
		} else {
			authz_ask_password($object, true);
		}
	} else {
		global $controller, $action, $id;
		$params = array('controller' => $controller, 'action' => $action, 'id' => $id);
		if ($retry) $params['retry'] = true;
		redirect_to(url_for('auth', '', $params));
	}
}
?>
