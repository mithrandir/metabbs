<?php
class Board extends Model {
	var $model = 'board';

	var $title;
	var $style = 'blueprint';

	var $perm_read = 0, $perm_write = 0, $perm_comment = 0;
	var $posts_per_page = 10;
	var $use_attachment = 0;
	var $use_category = 0;
	var $use_trackback = 1;
	var $order_by = '';
	var $header, $footer;

	function _init() {
		$this->admin_table = get_table_name('board_admin');
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
		return $this->db->fetchall("SELECT $fields FROM $this->post_table as p WHERE board_id=$this->id ORDER BY sort_key, id DESC LIMIT $offset, $limit", 'Post');
	}
	function get_posts_in_page($page) {
		return $this->get_posts(($page - 1) * $this->posts_per_page, $this->posts_per_page);
	}
	function get_feed_posts($count) {
		return $this->db->fetchall("SELECT * FROM $this->post_table WHERE board_id=$this->id AND NOT moved_to ORDER BY $this->order_by LIMIT $count", 'Post');
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
		$result = $this->db->get_result("SELECT id FROM $this->post_table WHERE board_id=$this->id");
		if ($result->count()) {
			$ids = array();
			while ($data = $result->fetch()) {
				$ids[] = $data['id'];
			}
			$this->db->execute("DELETE FROM $this->post_table WHERE moved_to IN (".implode(',', $ids).")");
		}
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
	function get_admins() {
		if (!isset($this->_admins)) {
			$table = get_table_name('user');
			$this->_admins = $this->db->fetchall("SELECT u.* FROM $this->admin_table a, $table u WHERE u.level=255 OR (a.board_id=$this->id AND a.user_id=u.id) GROUP BY u.id", "User");
		}
		return $this->_admins;
	}
	function is_admin($user) {
		foreach ($this->get_admins() as $admin) {
			if ($admin->id == $user->id) return true;
		}
		return false;
	}
	function add_admin($user) {
		foreach ($this->get_admins() as $admin) {
			if ($admin->id == $user->id) return;
		}
		$this->db->query("INSERT INTO $this->admin_table (board_id, user_id) VALUES($this->id, $user->id)");
	}
	function drop_admin($admin) {
		$this->db->query("DELETE FROM $this->admin_table WHERE board_id=$this->id AND user_id=$admin->id");
	}
	function reset_sort_keys() {
		if (!$this->order_by) $this->order_by = 'id DESC';
		$this->db->query("UPDATE $this->post_table SET sort_key=-id WHERE notice=1");
		preg_match('/^(.+?) (ASC|DESC)?$/', $this->order_by, $matches);
		list(, $key, $order) = $matches;
		if ($order == 'DESC')
			$this->db->query("UPDATE $this->post_table SET sort_key=2147483648-$key WHERE notice=0");
		else
			$this->db->query("UPDATE $this->post_table SET sort_key=$key WHERE notice=0");
	}
}
?>
