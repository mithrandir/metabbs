<?php
class Trackback extends Model {
	var $model = 'trackback';

	var $valid = true;
	function _init() {
		$this->table = get_table_name('trackback');
		$this->post_table = get_table_name('post');
	}
	function find($id) {
		$db = get_conn();
		$table = get_table_name('trackback');
		return $db->fetchrow("SELECT * FROM $table WHERE id=?", 'Trackback', array($id));
	}
	function get_post() {
		return Post::find($this->post_id);
	}
	function get_board() {
		$post = $this->get_post();
		return $post->get_board();
	}
	function validate() {
		return $this->valid && $this->url != '';
	}
}
?>
