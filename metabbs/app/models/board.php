<?php
class Board extends Model {
	var $model = 'board';

	var $title;
	var $style = 'board-default';

	var $perm_read = 0, $perm_write = 0, $perm_comment = 0;
	var $posts_per_page = 10;
	var $use_attachment = 0;
	var $use_category = 0;
	var $use_trackback = 1;
	var $order_by = '';
	var $header, $footer;

	var $get_post_body = FALSE;

	function _init() {
		$this->member_table = get_table_name('board_member');
		$this->post_table = get_table_name('post');
		$this->comment_table = get_table_name('comment');
		$this->category_table = get_table_name('category');
		$this->category_rel = new OneToManyRelation($this, 'category');
	}
	function get_id() {
		return $this->name;
	}
	function find($id) {
		return find('board', $id);
	}
	function find_by_name($name) {
		return find_by('board', 'name', $name);
	}
	function find_all() {
		return find_all('board');
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
		if (!$this->order_by) $this->order_by = 'id DESC';
		return find_all('post', "board_id=$this->id AND secret = 0 AND NOT moved_to", $this->order_by, $count);
	}
	function add_post(&$post) {
		$post->board_id = $this->id;
		$post->create();
		$board = $post->get_board();
		if($board->get_attribute('use_tag', false));
			$post->arrange_tags_after_create();
	}
	function get_post_count() {
		if (!isset($this->_count))
			$this->_count = count_all('post', "board_id=$this->id");
		return $this->_count;
	}
	function get_categories() {
		return find_all('category', "board_id=$this->id", "position");
	}
	function add_category($category) {
		$category->board_id = $this->id;
		$category->position = $this->db->fetchone("SELECT MAX(position) FROM {$category->table} WHERE board_id = $category->board_id") + 1;
		$category->create();
	}
	function delete() {
		$result = $this->db->query("SELECT id FROM $this->post_table WHERE board_id=$this->id");
		if ($result->count()) {
			$ids = array();
			while ($data = $result->fetch()) {
				$ids[] = $data['id'];
			}
			delete_all('post', "moved_to IN (".implode(',', $ids).")");
		}
		delete_all('post', "board_id=$this->id");
		apply_filters('BoardDelete', $this);
		Model::delete();
	}
	function get_recent_comments($count) {
		return $this->db->fetchall("SELECT * FROM $this->comment_table WHERE board_id=$this->id ORDER BY id DESC LIMIT $count", "Comment");
	}
	function get_style() {
		return new Style($this->style);
	}
	function change_style($style) {
		$this->db->execute("UPDATE $this->table SET style=? WHERE id=$this->id", array($style));
		$this->style = $style;
	}
	function get_members() {
		if (!isset($this->_members)) {
			$table = get_table_name('user');
			$this->_members = $this->db->fetchall("SELECT u.*, a.admin FROM $this->member_table a, $table u WHERE u.level=255 OR (a.board_id=$this->id AND a.user_id=u.id) GROUP BY u.id", "User");
		}
		return $this->_members;
	}
	function is_member($user) {
		foreach ($this->get_members() as $member) {
			if ($member->id == $user->id) return true;
		}
		return false;
	}
	function is_admin($user) {
		foreach ($this->get_members() as $member) {
			if ($member->id == $user->id && $member->admin) return true;
		}
		return false;
	}
	function add_member($user) {
		foreach ($this->get_members() as $member) {
			if ($member->id == $user->id) return;
		}
		$this->db->execute("INSERT INTO $this->member_table (board_id, user_id, admin) VALUES($this->id, $user->id, 0)");
	}
	function drop_member($user) {
		$this->db->execute("DELETE FROM $this->member_table WHERE board_id=$this->id AND user_id=$user->id");
	}
	function toggle_member_class($user) {
		$this->db->execute("UPDATE $this->member_table SET admin = 1 - admin WHERE board_id=$this->id AND user_id=$user->id");
	}
	function restrict_access() {
		return $this->get_attribute('restrict_access', false);
	}
	function restrict_write() {
		return $this->get_attribute('restrict_write', false);
	}
	function restrict_comment() {
		return $this->get_attribute('restrict_comment', false);
	}
	function restrict_attachment() {
		return $this->get_attribute('restrict_attachment', false);
	}
	function use_tag() {
		return $this->get_attribute('use_tag', false);
	}
	function reset_sort_keys() {
		if (!$this->order_by) $this->order_by = 'id DESC';
		$this->db->execute("UPDATE $this->post_table SET sort_key=-id WHERE notice=1");
		preg_match('/^(.+?) (ASC|DESC)?$/', $this->order_by, $matches);
		list(, $key, $order) = $matches;
		if ($order == 'DESC')
			$this->db->execute("UPDATE $this->post_table SET sort_key=2147483648-$key WHERE notice=0");
		else
			$this->db->execute("UPDATE $this->post_table SET sort_key=$key WHERE notice=0");
	}
	function have_empty_item() {
		return $this->get_attribute('have_empty_item', false);
	}
}
?>
