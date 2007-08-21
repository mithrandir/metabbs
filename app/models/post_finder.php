<?php
class PostFinder {
	var $order = 'p.id DESC';
	var $keyword = '';
	var $category = null;
	var $page = 1;
	var $conditions = array('title' => false, 'body' => false, 'comment' => false)

	function PostFinder($board) {
		$this->board = $board;
		$this->db = $GLOBALS['__db'];
		$this->table = get_table_name('post');
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
			if ($v) {
				switch ($k) {
					case 'comment':
						$or_parts[] = "c.post_id = p.id AND c.body LIKE '%$keyword%'";
					break;
					default:
						$or_parts[] = "p.$k LIKE '%$keyword%'";
					break;
				}
			}
		}
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
		$fields = 'p.id, p.board_id, p.user_id, p.category_id, p.name, p.title, p.created_at, p.notice, p.views, p.secret, p.moved_to, p.comment_count';
		if ($this->get_post_body) $fields .= ', p.body';
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
