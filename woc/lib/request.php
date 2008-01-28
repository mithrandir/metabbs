<?php
/**
 * post 호출인지 확인한다.
 * @return post 호출일때 참을 알려준다.
 */
function is_post() {
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_xhr() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

/**
 * 요청한 페이지 번호를 가져온다.
 * @return page를 get 호출로 전달한 경우 해당 페이지 번호를 반환한다.
 * 그렇지 않은 경우 1을 반환한다.
 */
function get_requested_page() {
	return isset($_GET['page']) ? $_GET['page'] : 1;
}

/**
 * 업로드 사이즈 제한을 얻는다.
 * @return 설정된 업로드 최대 값을 리턴한다.
 */
function get_upload_size_limit() {
	//return min(ini_get('post_max_size'), ini_get('upload_max_filesize'));
	return ini_get('upload_max_filesize');
}
?>
