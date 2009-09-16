<?php
class Attachment extends Model {
	var $model = 'attachment';

	function _init() {
		$this->table = get_table_name('attachment');
		$this->post_table = get_table_name('post');
	}
	function find($id) {
		$db = get_conn();
		$table = get_table_name('attachment');
		return $db->fetchrow("SELECT * FROM $table WHERE id=?", 'Attachment', array($id));
	}
	function get_post() {
		return Post::find($this->post_id);
	}
	function get_board() {
		$post = $this->get_post();
		return $post->exists() ? $post->get_board():null;
	}
	function is_image() {
		return is_image($this->filename);
	}
	function is_music() {
		return strrchr($this->filename, '.') == '.mp3';
	}
	function get_filename() {
		return 'data/uploads/' . $this->id;
	}
	function get_size() {
		return $this->file_exists() ? filesize($this->get_filename()) : false;
	}
	function file_exists() {
		return file_exists($this->get_filename());
	}
	function get_id() {
		return $this->id . '_' . $this->filename;
	}
	function get_content_type() {
		return $this->type ? $this->type : 'application/octet-stream';
	}
	function get_kind() {
		$board = $this->get_board();
		$kind = 0;
		if ($board->exists())
			$kind = $board->get_attribute('thumbnail_kind');

		return $kind;
	}
	function get_options() {
		$board = $this->get_board();
		if ($board->exists()) {
			$thumbnail_kind = $board->get_attribute('thumbnail_kind');
			$thumbnail_size = $board->get_attribute('thumbnail_size');
			$thumbnail_width = $board->get_attribute('thumbnail_width');
			$thumbnail_height = $board->get_attribute('thumbnail_height');

			switch ($thumbnail_kind) {
				case 4:
					$options = array('width' => $thumbnail_width, 'width' => $thumbnail_height);
					break;
				default:
					$options = array('size' => empty($thumbnail_size) ? 100 : $thumbnail_size);
			}
		} else {
			$options = array('size' => 100);
		}

		return $options;
	}
	function create_thumbnail($force = false) {
		$orig_path = $this->get_filename();
		if (!file_exists($orig_path)) return false;

		if ($this->is_image()) {
			requireCore('thumbnail');
			$ext = get_image_extension($orig_path);
			$thumb_path = 'data/thumb/'.$this->id.'-small.'.$ext;

			if($force) @unlink($thumb_path);

			if (!file_exists($thumb_path) and create_thumbnail($orig_path, $thumb_path, $this->get_kind(), $this->get_options())) {
				chmod($thumb_path, 0606);
			}
			return $thumb_path;
		}
		return false;
	}
	function get_thumbnail_url($full = false) {
		return ($full ? METABBS_HOST_URL : ''). '/'. $this->create_thumbnail();	
	}
}
?>
