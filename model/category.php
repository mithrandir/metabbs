<?php
class Category extends Model {
	var $model = 'category';

	function _init() {
		$this->table = get_table_name('category');
		$this->board_table = get_table_name('board');
		$this->post_table = get_table_name('post');
	}
	function find($id) {
		$db = get_conn();
		$table = get_table_name('category');
		return $db->fetchrow("SELECT * FROM $table WHERE id=$id", 'Category');
	}
	function get_board() {
		return Board::find($this->board_id);
	}
	function get_posts() {
		return $this->db->fetchall("SELECT * FROM $this->post_table WHERE category_id=$this->id", 'Post');
	}
	function add_post($post) {
		$post->category_id = $this->id;
		$post->create();
	}
	function get_post_count() {
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->post_table WHERE category_id=$this->id");
	}
	function delete() {
		$this->db->query("UPDATE $this->post_table SET category_id=0 WHERE category_id=$this->id");
		Model::delete();
	}
}
?>
