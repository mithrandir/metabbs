<?php
if (is_post() && isset($_FILES['data']) && is_uploaded_file($_FILES['data']['tmp_name'])) {
	@set_time_limit(0);
	$data = '';
	$fp = fopen($_FILES['data']['tmp_name'], 'r');
	while (!feof($fp)) {
		$data .= fread($fp, 1024);
	}
	$db = get_conn();
	foreach ($db->get_created_tables() as $table) {
		$db->execute("DELETE FROM $table");
	}
	foreach (explode(";\n", $data) as $query) {
		if (trim($query)) $db->execute($query);
	}
	print_notice('데이터를 복원하였습니다.', '다시 로그인 해야 할 수도 있습니다. <a href="'.url_for('admin').'">관리자 페이지로 돌아가기</a>');
}
?>
