<?php
class Category extends Model {
	var $model = 'category';

	function _init() {
		$this->table = get_table_name('category');
		$this->board_table = get_table_name('board');
		$this->post_table = get_table_name('post');
	}

	function find($id) {
		return find('category', $id);
	}
	
	function get_board() {
		return find('board', $this->board_id);
	}
	
	function get_post_count() {
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->post_table WHERE category_id=$this->id");
	}
	
	function delete() {
		$this->db->execute("UPDATE $this->post_table SET category_id=0 WHERE category_id=$this->id");
		Model::delete();
	}
}
?>
