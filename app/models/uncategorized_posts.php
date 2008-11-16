<?php
class UncategorizedPosts {
	var $id = 0;
	function UncategorizedPosts($board) {
		$this->board = $board;
		$this->db = $GLOBALS['__db'];
		$this->name = i('Uncategorized Posts');
	}
	function get_board() {
		return $this->board;
	}
	function get_post_count() {
		if (!isset($this->_count)) {
			$this->_count = $this->db->fetchone("SELECT COUNT(*) FROM {$this->board->post_table} WHERE board_id={$this->board->id} AND category_id=0");
		}
		return $this->_count;
	}
	function exists() {
		return $this->board->have_empty_item() || $this->get_post_count() > 0;
	}
}
?>
