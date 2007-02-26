<?php
class Board extends Model {
	var $model = 'board';

	var $search = array('title' => 1, 'body' => 1, 'comment' => 0, 'text' => '', 'category' => 0);
	var $category;
	var $title;
	var $style = 'default';

	var $posts_per_page = 10;
	var $use_attachment = 0;
	var $use_category = 0;
	var $use_trackback = 1;

	function _init() {
		$this->table = get_table_name('board');
		$this->post_table = get_table_name('post');
		$this->comment_table = get_table_name('comment');
		$this->category_table = get_table_name('category');
	}
	function get_id() {
		return $this->name;
	}
	function find($id) {
		$db = get_conn();
		$table = get_table_name('board');
		return $db->fetchrow("SELECT * FROM $table WHERE id=?", 'Board', array($id));
	}
	function find_by_name($name) {
		$db = get_conn();
		$table = get_table_name('board');
		return $db->fetchrow("SELECT * FROM $table WHERE name=?", 'Board', array($name));
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
	function get_condition() {
		$cond = "p.board_id=$this->id";
		$data = array();
		if ($text = $this->search['text']) {
			$text = '%' . $text . '%';
			$search = array();
			if ($this->search['comment']) {
				$search[] = "(p.id=c.post_id AND c.body LIKE ?)";
				$data[] = $text;
			}
			if ($this->search['title']) {
				$search[] = "p.title LIKE ?";
				$data[] = $text;
			}
			if ($this->search['body']) {
				$search[] = "p.body LIKE ?";
				$data[] = $text;
			}
			$cond .= " AND (" . implode(" OR ", $search) . ")";
		}
		if ($this->search['category']) {
			$cond .= " AND p.category_id=?";
			$data[] = $this->search['category'];
		}
		$this->search_data = $data;
		return $cond;
	}
	function get_posts($offset, $limit) {
		$where = $this->get_condition();
		return $this->db->fetchall("SELECT * FROM $this->post_table as p WHERE $where ORDER BY type DESC, id DESC LIMIT $offset, $limit", 'Post', $this->search_data);
	}
	function search_posts_with_comment($offset, $limit) {
		$where = $this->get_condition();
		return $this->db->fetchall("SELECT p.* FROM $this->post_table as p, $this->comment_table as c WHERE $where GROUP BY p.id ORDER BY p.type DESC, p.id DESC LIMIT $offset, $limit", 'Post', $this->search_data);
	}
	function get_posts_in_page($page, $method = 'get_posts') {
		return $this->$method(($page - 1) * $this->posts_per_page, $this->posts_per_page);
	}
	function get_feed_posts($count) {
		return $this->db->fetchall("SELECT * FROM $this->post_table WHERE board_id=$this->id ORDER BY id DESC LIMIT $count", 'Post');
	}
	function add_post(&$post) {
		$post->board_id = $this->id;
		$post->create();
	}
	function get_post_count() {
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->post_table WHERE board_id=$this->id");
	}
	function get_post_count_with_condition() {
		$query = "SELECT COUNT(*) FROM $this->post_table as p";
		if ($this->search['comment'])
			$query .= ", $this->comment_table as c";
		return $this->db->fetchone($query . " WHERE ".$this->get_condition(), $this->search_data);
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
}
?>
