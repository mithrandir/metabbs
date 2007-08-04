<?php
class Board extends Model {
	var $model = 'board';

	var $title;
	var $style = 'blueprint';

	var $perm_read = 0, $perm_write = 0, $perm_comment = 0;
	var $perm_delete = 255;
	var $posts_per_page = 10;
	var $use_attachment = 0;
	var $use_category = 0;
	var $use_trackback = 1;

	function _init() {
		$this->post_table = get_table_name('post');
		$this->comment_table = get_table_name('comment');
		$this->category_table = get_table_name('category');
	}
	function get_id() {
		return $this->name;
	}
	function find($id) {
		return find('board', 'id', $id);
	}
	function find_by_name($name) {
		return find('board', 'name', $name);
	}
	function find_all() {
		$db = get_conn();
		$table = get_table_name('board');
		return $db->fetchall("SELECT * FROM $table", 'Board');
	}
	function validate() {
		$_board = Board::find_by_name($this->name);
		return !$_board->exists();
	}
	function get_title() {
		return $this->title ? $this->title : @$this->name;
	}
	function get_posts($offset, $limit) {
		$fields = "id, board_id, user_id, category_id, name, title, created_at, notice, views, secret, moved_to";
		if ($this->get_post_body)
			$fields .= ', body';
		return $this->db->fetchall("SELECT $fields FROM $this->post_table as p WHERE board_id=$this->id ORDER BY notice DESC, id DESC LIMIT $offset, $limit", 'Post');
	}
	function get_posts_in_page($page) {
		return $this->get_posts(($page - 1) * $this->posts_per_page, $this->posts_per_page);
	}
	function get_feed_posts($count) {
		return $this->db->fetchall("SELECT * FROM $this->post_table WHERE board_id=$this->id ORDER BY id DESC LIMIT $count", 'Post');
	}
	function add_post(&$post) {
		$post->board_id = $this->id;
		$post->create();
	}
	function get_post_count() {
		if (!isset($this->_count))
			$this->_count = $this->db->fetchone("SELECT COUNT(*) FROM $this->post_table WHERE board_id=$this->id");
		return $this->_count;
	}
	function get_categories() {
		return $this->db->fetchall("SELECT * FROM $this->category_table WHERE board_id=$this->id", 'Category');
	}
	function add_category($category) {
		$category->board_id = $this->id;
		$category->create();
	}
	function get_category_count() {
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->category_table WHERE board_id=$this->id");
	}
	function delete() {
		Model::delete();
		$this->db->query("DELETE FROM $this->post_table WHERE board_id=$this->id");
	}
	function get_recent_comments($count) {
		return $this->db->fetchall("SELECT * FROM $this->comment_table WHERE board_id=$this->id ORDER BY id DESC LIMIT $count", "Comment");
	}
	function get_style() {
		return new Style($this->style);
	}
	function change_style($style) {
		$this->db->query("UPDATE $this->table SET style=? WHERE id=$this->id", array($style));
		$this->style = $style;
	}
}

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
