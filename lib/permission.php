<?php
function permission_required($action, $object) {
	global $account;
	if (!$account->has_perm($action, $object))
		access_denied();
}
function ask_password_of($object, $retry = false) {
	global $account;
	if (!$retry && is_post() && isset($_POST['_auth_password']) && $account->is_guest()) {
		$account->password = md5($_POST['_auth_password']);
		if ($account->password != $object->password) {
			ask_password_of($object, true);
		}
	} else {
		global $controller, $action, $id;
		$params = array('controller' => $controller, 'action' => $action, 'id' => $id);
		if ($retry) $params['retry'] = true;
		redirect_to(url_for('auth', '', $params));
	}
}
?>
