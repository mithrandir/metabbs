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
		$this->reset_position();
	}

	function reset_position() {
		$board = $this->get_board();
		$categories = $this->db->fetchall("SELECT id FROM $this->table WHERE board_id={$board->id} ORDER BY position ASC");
		$position = 1;
		foreach($categories AS $category) {
			$category->db->execute("UPDATE $this->table SET position={$position} WHERE id={$category->id}");
			$position++;
		}
	}

	function is_first() {
		$board = $this->get_board();
		$higher = $this->db->fetchrow("SELECT id, position FROM $this->table WHERE board_id = {$board->id} AND position <> 0 AND position < {$this->position} ORDER BY position DESC LIMIT 1");
		return !$higher->exists();
	}

	function is_last() {
		$board = $this->get_board();
		$lower = $this->db->fetchrow("SELECT id FROM $this->table WHERE board_id = {$board->id} AND position <> 0 AND position > {$this->position} ORDER BY position ASC LIMIT 1");
		return !$lower->exists();
	}

	function move_lower() {
		$board = $this->get_board();
		$lower = $this->db->fetchrow("SELECT id, position FROM $this->table WHERE board_id = {$board->id} AND position <> 0 AND position > {$this->position} ORDER BY position ASC LIMIT 1");
		if(!$lower->exists()) return false;
		$this->db->execute("UPDATE $this->table SET position={$this->position} WHERE id={$lower->id}");
		$this->db->execute("UPDATE $this->table SET position={$lower->position} WHERE id={$this->id}");
		return true;
	}

	function move_higher() {
		$board = $this->get_board();
		$higher = $this->db->fetchrow("SELECT id, position FROM $this->table WHERE board_id = {$board->id} AND position <> 0 AND position < {$this->position} ORDER BY position DESC LIMIT 1");
		if(!$higher->exists()) return false;
		$this->db->execute("UPDATE $this->table SET position={$this->position} WHERE id={$higher->id}");
		$this->db->execute("UPDATE $this->table SET position={$higher->position} WHERE id={$this->id}");
		return true;
	}
}
?>
