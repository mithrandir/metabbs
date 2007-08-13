<?php
class PostFinder {
	var $order = 'p.id DESC';
	var $keyword = '';
	var $category = null;

	function PostFinder($board) {
		$this->board = $board;
		$this->db = $GLOBALS['__db'];
		$this->table = get_table_name('post');
		$this->conditions = array('title' => false, 'body' => false, 'comment' => false);
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
		$keyword = $this->db->escape($this->keyword);
		$and_parts = array('p.board_id='.$this->board->id);
		$or_parts = array();
		foreach ($this->conditions as $k => $v) {
			if ($k == 'comment')
				continue;
			if ($v)
				$or_parts[] = "p.$k LIKE '%$keyword%'";
		}
		if($this->conditions['comment'])
			$or_parts[] = "c.post_id = p.id AND c.body LIKE '%$keyword%'";
		if ($or_parts)
			$and_parts[] = '('.implode(' OR ', $or_parts).')';
		if ($this->category)
			$and_parts[] = 'p.category_id='.$this->category->id;
		return implode(' AND ', $and_parts);
	}
	function get_from() {
		return "$this->table as p".(
			$this->conditions['comment'] ?
			', '.get_table_name('comment').' as c' : ''
		);
	}
	function get_posts() {
		$fields = trim('
			p.id as id,
			p.board_id as board_id,
			p.user_id as user_id,
			p.category_id as category_id,
			p.name as name,
			p.title as title,
			p.created_at as created_at,
			p.notice as notice,
			p.views as views,
			p.secret as secret,
			p.moved_to as moved_to
		');
		if ($this->get_post_body) $fields .= ', p.body as body';
		$from = $this->get_from();
		$offset = ($this->page - 1) * $this->board->posts_per_page;
		$limit = $this->board->posts_per_page;
		$condition = $this->get_condition();
		return $this->db->fetchall("SELECT $fields FROM $from WHERE $condition GROUP BY p.id ORDER BY p.notice DESC, $this->order LIMIT $offset, $limit", 'Post');
	}
	function get_post_count() {
		$fields = $this->conditions['comment'] ? 'p.id' : 'COUNT(*)';
		$from = $this->get_from();
		$condition = $this->get_condition();
		$query = "SELECT $fields FROM $from WHERE $condition".($this->conditions['comment'] ? ' GROUP BY p.id' : '');
		if(!$this->conditions['comment'])
			return $this->db->fetchone($query);
		list($major, $minor) = $this->db->get_server_version();
		if ($major == 4 && $minor >= 1 || $major > 4)
			return $this->db->fetchone("SELECT COUNT(*) FROM ($query) as q");
		$result = $this->db->get_result($query);
		return $result->count();
	}
}
?>
