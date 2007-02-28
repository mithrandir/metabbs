<?php
class Thumbnail extends Plugin {
	var $description = 'Generate thumbnail images in gallery skin.';
	function on_install() {
		@mkdir('data/thumb', 0707);
	}
	function on_init() {
		add_handler('attachment', 'index', array(&$this, 'attachment_hook'), 'before');
		add_filter('PostDelete', array(&$this, 'delete_thumbnail'), 50);
	}
	function attachment_hook() {
		if (isset($_GET['thumb'])) {
			list($id) = explode('_', $GLOBALS['id'], 2);
			$attachment = Attachment::find($id);
			if ($attachment->exists()) {
				$thumb_path = 'data/thumb/'.$attachment->id.'.png';
				if ($this->create_thumbnail('data/uploads/'.$attachment->id, $thumb_path)) {
					redirect_to(METABBS_BASE_PATH . $thumb_path);
				}
			}
		}
	}
	function delete_thumbnail($post) {
		$attachments = $post->get_attachments();
		foreach ($attachments as $attachment) {
			@unlink('data/thumb/'.$attachment->id.'.png');
		}
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
}

register_plugin('Thumbnail');
?>
