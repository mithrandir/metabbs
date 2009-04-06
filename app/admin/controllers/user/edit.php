<?php
check_form_token();
if (isset($_POST['mass_operation'])) {
	$level = $_POST['level'];
	foreach ($_POST['user_id'] as $params['id'] => $check) {
		$user = User::find($params['id']);
		switch ($_POST['mass_operation']) {
		case 'level':
			$user->level = $level;
			$user->update();
			break;
		case 'delete':
			$user->delete();
			break;
		}
	}
}
redirect_to(url_admin_for('user', null, array('page' => $_GET['page'])));
?>
