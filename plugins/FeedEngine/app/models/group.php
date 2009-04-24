<?php
class Group extends Model {
	var $model = 'group';

	function _init() {
		$this->table = get_table_name('group');
		$this->group_post_table = get_table_name('group_post');
		$this->board_table = get_table_name('board');
		$this->post_table = get_table_name('post');
	}

	function find($id) {
		return find('group', $id);
	}
	function find_all() {
		return find_all('group', '', 'board_id, position ASC');
	}
	function find_by_name($name) {
		return find_by('group', 'name', $name);
	}
	function find_by_name_and_board($name, $board) {
		$db = get_conn();
		$table = get_table_name('group');
		return $db->fetchRow("SELECT * FROM $table WHERE board_id = ? AND name= ?", 'Post', array($board->id, $name));
	}
	function get_board() {
		return find('board', $this->board_id);
	}
	function find_all_by_board($board) {
		$db = get_conn();
		$table = get_table_name('group');
		return $db->fetchAll("SELECT * FROM $table WHERE board_id = ? ORDER BY position ASC", 'Post', array($board->id));
	}
	function get_post_count() {
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->group_post_table WHERE group_id=$this->id");
	}
	function get_posts() {
/*		$fields = "id, board_id, user_id, category_id, name, title, created_at, notice, views, secret, moved_to";
		if ($this->get_post_body)
			$fields .= ', body';
		return $this->db->fetchall("SELECT $fields FROM $this->post_table as p WHERE board_id=$this->id ORDER BY sort_key, id DESC LIMIT $offset, $limit", 'Post');*/
	}
	function create() {
		$this->position = $this->db->fetchone("SELECT MAX(position) FROM $this->table WHERE board_id = $this->board_id") + 1;
		$this->created_at = $this->updated_at = time();
		Model::create();
	}
	function update() {
		$this->updated_at = time();
		Model::update();
	}
	function delete() {
		$this->db->execute("DELETE FROM $this->group_post_table WHERE group_id=$this->id");
		Model::delete();
		$this->reset_position();
	}

	function reset_position() {
		$board = $this->get_board();
		$groups = $this->db->fetchall("SELECT id FROM $this->table WHERE board_id={$board->id} ORDER BY position ASC");
		$position = 1;
		foreach($groups AS $group) {
			$group->db->execute("UPDATE $this->table SET position={$position} WHERE id={$group->id}");
			$position++;
		}
	}
	function is_related($post) {
		$group_post = GroupPost::find_by_group_and_post($this, $post);
		return $group_post->exists();
	}
	function relate_to_post($post) {
		$group_post = GroupPost::find_by_group_and_post($this, $post);
		if(!$group_post->exists()) {
			unset($group_post);
			$group_post = new GroupPost(array('group_id' => $this->id, 'post_id' => $post->id));
			$group_post->create();

			return true;
		}
		return false;
	}
	function unrelate_to_post($post) {
		$group_post = GroupPost::find_by_group_and_post($this, $post);
		if($group_post->exists()) {
			$group_post->delete();

			return true;
		}
		return false;
	}
	function is_first() {
		$board = $this->get_board();
		$higher = $this->db->fetchrow("SELECT id, position FROM $this->table WHERE board_id = {$board->id} AND position <> 0 AND position < {$this->position} ORDER BY position DESC LIMIT 1");
		return !$higher->exists();
	}

	function is_last() {
		$board = $this->get_board();
		$lower = $this->db->fetchrow("SELECT id FROM $this->table WHERE board_id = {$board->id} AND position <> 0 AND position > {$this->position} ORDER BY position ASC LIMIT 1");
		return !$lower->exists();
	}

	function move_lower() {
		$board = $this->get_board();
		$lower = $this->db->fetchrow("SELECT id, position FROM $this->table WHERE board_id = {$board->id} AND position <> 0 AND position > {$this->position} ORDER BY position ASC LIMIT 1");
		if(!$lower->exists()) return false;
		$this->db->execute("UPDATE $this->table SET position={$this->position} WHERE id={$lower->id}");
		$this->db->execute("UPDATE $this->table SET position={$lower->position} WHERE id={$this->id}");
		return true;
	}

	function move_higher() {
		$board = $this->get_board();
		$higher = $this->db->fetchrow("SELECT id, position FROM $this->table WHERE board_id = {$board->id} AND position <> 0 AND position < {$this->position} ORDER BY position DESC LIMIT 1");
		if(!$higher->exists()) return false;
		$this->db->execute("UPDATE $this->table SET position={$this->position} WHERE id={$higher->id}");
		$this->db->execute("UPDATE $this->table SET position={$higher->position} WHERE id={$this->id}");
		return true;
	}
}
?>
