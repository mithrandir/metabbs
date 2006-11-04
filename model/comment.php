<?php
class Comment extends Model {
	var $model = 'comment';
	var $comments = array();

	function _init() {
		$this->table = get_table_name('comment');
		$this->user_table = get_table_name('user');
		$this->post_table = get_table_name('post');
	}
	function find($id) {
		$db = get_conn();
		$table = get_table_name('comment');
		return $db->fetchrow("SELECT *, created_at+0 as created_at FROM $table WHERE id=$id", 'Comment');
	}
	function create() {
		$this->created_at = model_datetime();
		$this->password = md5(@$this->password);
		Model::create();
	}
	function get_user() {
		return User::find($this->user_id);
	}
	function get_post() {
		return Post::find($this->post_id);
	}
	function get_board() {
		$post = $this->get_post();
		return $post->get_board();
	}
}

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
