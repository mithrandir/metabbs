<?php
function english_patient_filter($model) {
	$regex = '/^[\\x{00}-\\x{7F}]+$/u';
	if (preg_match($regex, $model->title) && preg_match($regex, $model->excerpt)) {
		$model->valid = false;
	}
}

add_filter('PostTrackback', 'english_patient_filter', 10);
?>
