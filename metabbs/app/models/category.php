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
	function find_by_name($name) {
		return find_by('category', 'name', $name);
	}
	function get_board() {
		return find('board', $this->board_id);
	}
	function get_post_count() {
		return count_all('post', 'category_id='.$this->id);
	}
	
	function delete() {
		update_all('post', array('category_id' => 0), "category_id=$this->id");
		Model::delete();
		$this->reset_position();
	}

	function reset_position() {
		$board = $this->get_board();
		$categories = $board->get_categories();
		$position = 1;
		foreach ($categories as $category) {
			if ($category->position != $position)
				update_all('category', array('position' => $position), 'id=' . $category->id);
			if ($category->id == $this->id)
				$this->position = $position;
			$position++;
		}
	}

	function is_first() {
		return $this->position == $this->db->fetchone("SELECT MIN(position) FROM $this->table WHERE board_id={$this->board_id} AND position != 0");
	}

	function is_last() {
		return $this->position == $this->db->fetchone("SELECT MAX(position) FROM $this->table WHERE board_id={$this->board_id} AND position != 0");
	}

	function move_lower() {
		if ($this->is_last())
			return false;

		$this->reset_position(); // ensure that positions are unique and sequential
		update_all('category', array('position' => $this->position), "board_id=$this->board_id AND position=".($this->position + 1));
		update_all('category', array('position' => $this->position + 1), 'id=' . $this->id);
		$this->position++;
		return true;
	}

	function move_higher() {
		if ($this->is_first())
			return false;

		$this->reset_position(); // ensure that positions are unique and sequential
		update_all('category', array('position' => $this->position), "board_id=$this->board_id AND position=".($this->position - 1));
		update_all('category', array('position' => $this->position - 1), 'id=' . $this->id);
		$this->position--;
		return true;
	}
}
?>
