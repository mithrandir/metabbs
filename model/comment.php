<?php
class Comment extends Model {
	function _init() {
		$this->table = get_table_name('comment');
		$this->user_table = get_table_name('user');
		$this->post_table = get_table_name('post');
	}
	function find($id) {
		$db = get_conn();
		$table = get_table_name('comment');
		return $db->fetchrow("SELECT * FROM $table WHERE id=$id", 'Comment');
	}
	function get_user() {
		return User::find($this->user_id);
	}
	function get_post() {
		return Post::find($this->post_id);
	}
	function create() {
		$this->created_at = model_datetime();
		Model::create();
	}
}
?>
