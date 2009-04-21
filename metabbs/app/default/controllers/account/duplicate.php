<?php
if (is_xhr() && isset($_GET['user'])) {
	$user = User::find_by_user($_GET['user']);
	if ($user->exists()) {
		echo '이미 사용중인 아이디입니다.';
	} else {
		echo '사용할 수 있는 아이디입니다.';
	}
	exit;
}
?>