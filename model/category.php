<?php
class Category extends Model {
	function _init() {
		$this->board = $this->belongs_to('board');
	}
	function get_board() {
		return $this->board->find();
	}
	function get_posts($offset, $limit) {
		return model_find_all('post', 'board_id='.$this->board_id.' AND category_id='.$this->id, 'type DESC, id DESC', $offset, $limit);
	}
	function delete() {
		model_update('post', array('category_id' => 0), 'category_id='.$this->id);
		Model::delete();
	}
}
?>
