<?php
if ($action != 'edit') {
	if (!isset($id)) {
		print_notice(i('No user id'), i('Please append the user id.'));
	}
	$user = User::find_by_user($id);
	if (!$user->exists()) {
		print_notice(i('User not found'), i("User '%s' doesn't exist.", htmlspecialchars($id)));
	}
}
$title = htmlspecialchars($user->name);
?>
