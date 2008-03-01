<?php
class PostFinder {
	var $keyword = '';
	var $category = null;
	var $page = 1;
	var $conditions = array('author' => false, 'title' => false, 'body' => false, 'comment' => false);
	var $exclude_notice = false;
	var $get_post_body = true;

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
	function set_page($page) {
		$this->page = $page;
	}
	function set_category($category) {
		$this->category = $category;
	}
	function get_condition() {
		$keyword = $this->db->escape($this->keyword);
		$and_parts = array('board_id='.$this->board->id);
		$or_parts = array();
		if ($this->exclude_notice) {
			$and_parts[] = 'notice=0';
		}
		foreach ($this->conditions as $k => $v) {
			if ($v) {
				switch ($k) {
					case 'comment':
						$result = $this->db->query("SELECT post_id FROM ".get_table_name('comment')." WHERE board_id={$this->board->id} AND body LIKE '%$keyword%'");
						// TODO: subquery
						$ids = array();
						if ($result->count()) {
							while ($data = $result->fetch()) {
								$ids[] = $data['post_id'];
							}
							$or_parts[] = "id IN (".implode(',', $ids).")";
						} else {
							$or_parts[] = "0";
						}
					break;
					case 'author':
						$or_parts[] = "name LIKE '%$keyword%'";
					break;
					default:
						$or_parts[] = "$k LIKE '%$keyword%'";
					break;
				}
			}
		}
		if ($or_parts)
			$and_parts[] = '('.implode(' OR ', $or_parts).')';
		if ($this->category)
			$and_parts[] = 'category_id='.$this->category->id;
		return implode(' AND ', $and_parts);
	}
	function get_fields() {
		$fields = 'id, board_id, user_id, category_id, name, title, created_at, notice, views, secret, moved_to, comment_count';
		if ($this->get_post_body) $fields .= ', body';
		return $fields;
	}
	function get_posts() {
		$fields = $this->get_fields();
		$offset = ($this->page - 1) * $this->board->posts_per_page;
		$limit = $this->board->posts_per_page;
		$condition = $this->get_condition();
		return $this->db->fetchall("SELECT $fields FROM $this->table WHERE $condition ORDER BY sort_key, id DESC LIMIT $offset, $limit", 'Post');
	}
	function get_notice_posts() {
		$fields = $this->get_fields();
		return $this->db->fetchall("SELECT $fields FROM $this->table WHERE board_id={$this->board->id} AND notice=1 ORDER BY sort_key, id DESC", 'Post');
	}
	function get_post_count() {
		$condition = $this->get_condition();
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->table WHERE $condition");
	}
}
?>
