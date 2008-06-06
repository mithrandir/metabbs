<?php
if (!$account->is_admin()) {
	access_denied();
} else {
	$user = User::find($id);
	$user->delete();
	redirect_to(url_for('admin', 'users', array('page' => $_GET['page'])));
}
?>
