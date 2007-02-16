<?php
if (!$account->is_admin()) {
	access_denied();
} else {
	if (isset($_POST['mass_operation'])) {
		$level = $_POST['level'];
		foreach ($_POST['user_id'] as $id => $check) {
			$user = User::find($id);
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
	redirect_to(url_for('admin', 'users'));
}
?>
