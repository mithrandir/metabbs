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
}
?>