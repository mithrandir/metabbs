<?php
$english_patient_regex = '/^[\\x{00}-\\x{7F}]+$/u';
function english_patient_tb_filter($model) {
	global $english_patient_regex;
	if (preg_match($english_patient_regex, $model->title) && preg_match($english_patient_regex, $model->excerpt)) {
		$model->valid = false;
	}
}
function english_patient_cmt_filter($model) {
	global $english_patient_regex;
	if (strlen($model->body) > 10 && preg_match($english_patient_regex, $model->body)) {
		echo "<h2>English Patient plugin enabled!</h2>";
		echo "you can't post a comment only with ascii characters.";
		exit;
	}
}
function english_patient_post_filter($model) {
	global $english_patient_regex;
	if (preg_match($english_patient_regex, $model->title) &&
		preg_match($english_patient_regex, $model->body)) {
		echo "<h2>English Patient plugin enabled!</h2>";
		echo "you can't post a comment only with ascii characters.";
		exit;
	}
}

add_filter('PostTrackback', 'english_patient_tb_filter', 10);
add_filter('PostComment', 'english_patient_cmt_filter', 20);
add_filter('PostSave', 'english_patient_post_filter', 20);
?>
