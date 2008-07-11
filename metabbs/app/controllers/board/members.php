<?php
if (!$account->is_admin()) {
	access_denied();
}

switch ($_GET['action']) {
	case 'add':
		$user = User::find_by_user($_POST['member_id']);
		if ($user->exists() && !$user->is_admin())
			$board->add_member($user);
	break;
	case 'drop':
		$admin = User::find($_GET['id']);
		if ($admin->exists())
			$board->drop_member($admin);
	break;
}
redirect_to(url_for($board, 'edit', array('tab' => 'permission')));
?>
