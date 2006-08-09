<?php
class Attachment extends Model {
	function _init() {
		$this->table = get_table_name('attachment');
		$this->post_table = get_table_name('post');
	}
	function find($id) {
		$db = get_conn();
		$table = get_table_name('attachment');
		return $db->fetchrow("SELECT * FROM $table WHERE id=$id", 'Attachment');
	}
	function get_post() {
		return Post::find($this->post_id);
	}
	function is_image() {
		return is_image($this->filename);
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
}
?>
