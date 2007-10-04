<?php
if (!file_exists('data/thumb')) {
	@mkdir('data/thumb', 0707);
}

function get_image_extension($path) {
	list($width, $height, $type) = getimagesize($path);
	if ($type == 1)
		return 'gif';
	else if ($type == 2)
		return 'jpg';
	else if ($type == 3)
		return 'png';
	else
		return null;
}

function create_thumbnail($path, $dest) {
	if (!file_exists($dest)) {
		ini_set('memory_limit', '-1');
		list($width, $height, $type) = getimagesize($path);
		if ($height <= 130) return false;
		$thumb = imagecreatetruecolor($width * (130 / $height), 130);
		if ($type == 1) {
			$source = imagecreatefromgif($path);
			$func = 'imagegif';
		} else if ($type == 2) {
			$source = imagecreatefromjpeg($path);
			$func = 'imagejpeg';
		} else if ($type == 3) {
			$source = imagecreatefrompng($path);
			$func = 'imagepng';
		} else {
			return;
		}
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, imagesx($thumb), imagesy($thumb), $width, $height);
		return $func($thumb, $dest);
	}
	return true;
}
?>
