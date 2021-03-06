<?php
define('ASK_PASSWORD', 2);

function permission_required($action, $object) {
	global $account;
	$result = $account->has_perm($action, $object);
	if (!$result)
		access_denied();
	else if ($result === ASK_PASSWORD)
		ask_password_of($object);
}
function ask_password_of($object, $retry = false) {
	global $account;
	if (!$retry && is_post() && isset($_POST['_auth_password']) && $account->is_guest()) {
		$account->password = md5($_POST['_auth_password']);
		if ($account->password != $object->password) {
			ask_password_of($object, true);
		}
	} else {
		$params = $_GET;
		if ($retry) $params['retry'] = true;
		redirect_to(url_with_referer_for('auth', null, $params));
	}
}
?>
