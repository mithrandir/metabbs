<?php
class Category extends Model {
	var $board_id, $name;
	function get_board() {
		return Board::find($this->board_id);
	}
	function get_posts($offset, $limit) {
		return model_find_all('post', 'board_id='.$this->board_id.' AND category_id='.$this->id, 'type DESC, id DESC', $offset, $limit);
	}
	function find($id) {
		return model_find('category', $id);
	}
	function delete() {
		model_update('post', array('category_id' => 0), 'category_id='.$this->id);
		return model_delete('category', 'id='.$this->id);
	}
}
?>
