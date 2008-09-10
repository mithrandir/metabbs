<?php
if (!file_exists('data/thumb')) {
	@mkdir('data/thumb');
	@chmod('data/thumb', 0707);
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

function create_thumbnail($path, $dest, $kind = 0, $size = 130) {
	if (!file_exists($dest)) {
		ini_set('memory_limit', '-1');
		list($width, $height, $type) = getimagesize($path);
		switch($kind) {
			// 가로폭이 size로 고정 축소
			case 0:
				if ($width <= $size || $height <= $size) return false;
				$src_x = 0;
				$src_y = 0;
				$src_w = $width;
				$src_h = $height;
				$dst_x = 0;
				$dst_y = 0;
				$dst_w = $width / $height * $size;
				$dst_h = $size;
				break;
			// 큰축을 size로 고정 축소
			case 1:
				if ($width <= $size || $height <= $size) return false;
				$src_x = 0;
				$src_y = 0;
				$src_w = $width;
				$src_h = $height;
				$dst_x = 0;
				$dst_y = 0;
				if($width > $height) {
					$dst_w = $width / $height * $size;
					$dst_h = $size;
				} else {
					$dst_w = $size;
					$dst_h = $height / $width * $size;
				}
				break;
			// 작은축을 size로 고정 축소
			case 2:
				if ($width <= $size || $height <= $size) return false;
				$src_x = 0;
				$src_y = 0;
				$src_w = $width;
				$src_h = $height;
				$dst_x = 0;
				$dst_y = 0;
				if($width > $height) {
					$dst_w = $size;
					$dst_h = $height / $width * $size;
				} else {
					$dst_w = $width / $height * $size;
					$dst_h = $size;
				}
				break;
			// size의 정사각형으로 잘라내기 축소
			case 3:
				if ($width <= $size || $height <= $size) return false;
				$src_x = 0;
				$src_y = 0;
				if($width > $height) {
					$src_x = ($width - $height) / 2;
					$src_w = $src_h = $height;
				} else {
					$src_y = ($height - $width) / 2;
					$src_w = $src_h = $width;
				}
				$dst_x = 0;
				$dst_y = 0;
				$dst_w = $size;
				$dst_h = $size;
				break;
		}
		$thumb = imagecreatetruecolor($dst_w, $dst_h);
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
		imagecopyresampled($thumb, $source, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		return $func($thumb, $dest);
	}
	return true;
}
?>
