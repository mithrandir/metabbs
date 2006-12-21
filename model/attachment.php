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
		return filesize($this->get_filename());
	}
	function file_exists() {
		return file_exists($this->get_filename());
	}
	function get_id() {
		return rawurlencode($this->id . '_' . $this->filename);
	}
	function get_content_type() {
		return $this->type ? $this->type : 'application/octet-stream';
	}
}
?>
