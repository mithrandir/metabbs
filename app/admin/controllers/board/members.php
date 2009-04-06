<?php
switch ($params['action']) {
	case 'add':
		$user = User::find_by_user($params['member_id']);
		if ($user->exists() && !$user->is_admin())
			$board->add_member($user);
	break;
	case 'drop':
		$member = User::find($params['member_id']);
		if ($member->exists())
			$board->drop_member($member);
	break;
	case 'toggle':
		$member = User::find($params['member_id']);
		if ($member->exists() && !$member->is_admin())
			$board->toggle_member_class($member);
	break;
}
redirect_to(url_admin_for($board, 'edit', array('tab' => 'permission')));
?>
