<?php
class Board extends Model {
	var $search = array('title' => 1, 'body' => 1, 'text' => '', 'category' => 0);
	var $category;
	var $title;
	var $posts_per_page = 10;
	var $perm_delete = 255;
	var $skin = 'default';
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
		return $db->fetchrow("SELECT * FROM $table WHERE id=$id", 'Board');
	}
	function find_by_name($name) {
		$db = get_conn();
		$table = get_table_name('board');
		return $db->fetchrow("SELECT * FROM $table WHERE name='$name'", 'Board');
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
		$cond = "board_id=$this->id";
		if ($text = $this->search['text']) {
			$search = array();
			if ($this->search['title'])
				$search[] = "title LIKE '%$text%'";
			if ($this->search['body'])
				$search[] = "body LIKE '%$text%'";
			$cond .= " AND (" . implode(" OR ", $search) . ")";
		}
		if ($this->search['category']) {
			$cond .= " AND category_id=" . $this->search['category'];
		}
		return $cond;
	}
	function get_posts($offset, $limit) {
		$where = $this->get_condition();
		return $this->db->fetchall("SELECT *, created_at+0 as created_at FROM $this->post_table WHERE $where ORDER BY type DESC, id DESC LIMIT $offset, $limit", 'Post');
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
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->post_table WHERE ".$this->get_condition());
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
}
?>
