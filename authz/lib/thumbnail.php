<?php
if (!file_exists('data/thumb')) {
	@mkdir('data/thumb', 0707);
}

function create_thumbnail($path, $dest) {
	if (!file_exists($dest)) {
		ini_set('memory_limit', '-1');
		list($width, $height, $type) = getimagesize($path);
		if ($height <= 130) return false;
		$thumb = imagecreatetruecolor($width * (130 / $height), 130);
		if ($type == 1)
			$source = imagecreatefromgif($path);
		else if ($type == 2)
			$source = imagecreatefromjpeg($path);
		else if ($type == 3)
			$source = imagecreatefrompng($path);
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, imagesx($thumb), imagesy($thumb), $width, $height);
		return imagepng($thumb, $dest);
	}
	return true;
}
?>
