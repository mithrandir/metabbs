<?php
class PostFinder {
	var $order = 'id DESC';
	var $keyword = '';
	var $category = null;

	function PostFinder($board) {
		$this->board = $board;
		$this->db = $GLOBALS['__db'];
		$this->table = get_table_name('post');
		$this->conditions = array('title' => false, 'body' => false);
	}
	function set_keyword($keyword) {
		$this->keyword = $keyword;
	}
	function add_condition($key) {
		$this->conditions[$key] = true;
	}
	function order_by($field) {
		$this->order = $field;
	}
	function set_page($page) {
		$this->page = $page;
	}
	function set_category($category) {
		$this->category = $category;
	}
	function get_condition() {
		$and_parts = array('board_id='.$this->board->id);
		$or_parts = array();
		foreach ($this->conditions as $k => $v) {
			if ($v) $or_parts[] = "$k LIKE '%".$this->db->escape($this->keyword)."%'";
		}
		if ($or_parts)
			$and_parts[] = '('.implode(' OR ', $or_parts).')';
		if ($this->category)
			$and_parts[] = 'category_id='.$this->category->id;
		return implode(' AND ', $and_parts);
	}
	function get_posts() {
		$fields = "id, board_id, user_id, category_id, name, title, created_at, notice, views, secret, moved_to";
		if ($this->get_post_body) $fields .= ', body';
		$offset = ($this->page - 1) * $this->board->posts_per_page;
		$limit = $this->board->posts_per_page;
		$condition = $this->get_condition();
		return $this->db->fetchall("SELECT $fields FROM $this->table WHERE $condition ORDER BY notice DESC, $this->order LIMIT $offset, $limit", 'Post');
	}
	function get_post_count() {
		$condition = $this->get_condition();
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->table WHERE $condition");
	}
}
?>
