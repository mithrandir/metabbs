<?php
if (!$user->is_admin()) {
	access_denied();
} else {
	$level = $_POST['level'];
	foreach ($_POST['user_id'] as $id => $check) {
		$_user = User::find($id);
		$_user->level = $level;
		$_user->update();
	}
	redirect_to(url_for('admin', 'users'));
}
?>
