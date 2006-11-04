<?php
if (!$account->is_admin()) {
	access_denied();
} else {
	$level = $_POST['level'];
	foreach ($_POST['user_id'] as $id => $check) {
		$user = User::find($id);
		$user->level = $level;
		$user->update();
	}
	redirect_to(url_for('admin', 'users'));
}

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
