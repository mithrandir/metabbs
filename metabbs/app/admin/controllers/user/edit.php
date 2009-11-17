<?php
check_form_token();
if (is_post()) {
	if (isset($params['mass_operation'])) {
		$level = $params['level'];
		foreach ($params['user_id'] as $params['id'] => $check) {
			$user = User::find($params['id']);
			switch ($params['mass_operation']) {
			case 'level':
				$user->level = $level;
				$user->update();
				break;
			case 'delete':
				$user->delete();
				break;
			}
		}
		switch ($params['mass_operation']) {
			case 'level':
				Flash::set(i('Users\'s Level has been changed'));
				break;
			case 'delete':
				Flash::set(i('Users has been deleted'));
				break;
		}
	}
}
redirect_back();
?>
