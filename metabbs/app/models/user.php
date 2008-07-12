<?php
class User extends Model {
	var $model = 'user';

	var $email, $url;
	var $level = 1;
	var $token;
	var $signature = '';
	function _init() {
		$this->table = get_table_name('user');
		$this->post_table = get_table_name('post');
		$this->comment_table = get_table_name('comment');
	}
	function find($id) {
		$db = get_conn();
		$table = get_table_name('user');
		return $db->fetchrow("SELECT * FROM $table WHERE id=?", 'User', array($id));
	}
	function get_posts($offset, $limit) {
		return $this->db->fetchall("SELECT * FROM $this->post_table WHERE user_id=$this->id ORDER BY id DESC LIMIT $offset, $limit", 'Post');
	}
	function get_post_count() {
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->post_table WHERE user_id=$this->id");
	}
	function get_comments() {
		return $this->db->fetchall("SELECT * FROM $this->comment_table WHERE user_id=$this->id", 'Comment');
	}
	function get_comment_count() {
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->comment_table WHERE user_id=$this->id");
	}
	function auth($user, $password) {
		$db = get_conn();
		$table = get_table_name('user');
		$user = $db->fetchrow("SELECT * FROM $table WHERE user=? AND password=?", 'User', array($user, $password));
		if ($user->exists()) {
			return $user;
		} else {
			return new Guest;
		}
	}
	function find_by_user($user) {
		$db = get_conn();
		$table = get_table_name('user');
		return $db->fetchrow("SELECT * FROM $table WHERE user=?", 'User', array($user));
	}
	function find_all($offset, $limit) {
		$db = get_conn();
		$table = get_table_name('user');
		return $db->fetchall("SELECT * FROM $table LIMIT $offset, $limit", 'User');
	}
	function search($key, $value) {
		$db = get_conn();
		$table = get_table_name('user');
		return $db->fetchall("SELECT * FROM $table WHERE ! LIKE '%!%'", 'User', array($key, $value));
	}
	function count() {
		$db = get_conn();
		$table = get_table_name('user');
		return $db->fetchone("SELECT COUNT(*) FROM $table");
	}
	function is_guest() {
		return false;
	}
	function is_admin() {
		return $this->level == 255;
	}
	function valid() {
		$user = User::find_by_user($this->user);
		return !$user->exists();
	}
	function get_url() {
		if (strpos($this->url, "http://") !== 0) {
			return 'http://' . $this->url;
		} else {
			return $this->url;
		}
	}
	function set_token($token) {
		$this->db->execute("UPDATE $this->table SET token='$token' WHERE id=$this->id");
	}
	function unset_token() {
		$this->set_token('');
	}
	function has_perm($action, $object) {
		if ($this->is_admin()) return true;
		if (is_a($object, 'Board'))
			$board = $object;
		else if (method_exists($object, 'get_board'))
			$board = $object->get_board();
		if (isset($board) && $board->is_admin($this))
			return true;

		switch ($action) {
			case 'list':
				if ($board->get_attribute('always_show_list', false))
					return true;

				if ($this->level < $board->perm_read)
					return false;

				if ($board->restrict_access())
					return $board->is_member($this);
				else
					return true;
			break;
			case 'read':
				if ($object->secret && $object->user_id != $this->id &&
					!$this->has_perm('admin', $board))
					return false;

				if ($this->level < $board->perm_read)
					return false;

				if ($board->restrict_access())
					return $board->is_member($this);
				else
					return true;
			break;
			case 'admin':
				return $object->is_admin($this);
			break;
			case 'write':
				if ($this->level < $object->perm_write)
					return false;

				if ($object->restrict_write())
					return $object->is_member($this);
				else
					return true;
			break;
			case 'delete':
			case 'edit':
				if (!is_a($object, 'Board'))
					$board = $object->get_board();
				else
					$board = $object;

				return $this->has_perm('admin', $board) ||
					(isset($object->user_id) && $object->user_id == $this->id);
			break;
			case 'reply':
			case 'comment':
				if ($this->level < $board->perm_comment)
					return false;

				if ($board->restrict_comment())
					return $board->is_member($this);
				else
					return true;
			break;
		}
	}
}

class Guest extends Model
{
	var $user;
	var $id = 0;
	var $level = 0;
	var $name = 'guest';
	var $email, $url;
	var $signature;
	function is_guest() {
		return true;
	}
	function is_admin() {
		return false;
	}
	function has_perm($action, $object) {
		switch ($action) {
			case 'list':
				return $object->get_attribute('always_show_list', false)
					|| $this->level >= $object->perm_read;
			break;
			case 'read':
				$board = $object->get_board();
				if ($object->secret) {
					if ($object->user_id == 0)
						return ASK_PASSWORD;
					else
						return false;
				}
				return $this->level >= $board->perm_read;
			break;
			case 'admin':
				return false;
			break;
			case 'write':
				return ($object->restrict_write() && $object->is_member($this) && $this->level >= $object->perm_write)
					|| (!$object->restrict_write() && $this->level >= $object->perm_write);
			break;
			case 'delete':
			case 'edit':
				if (!is_a($object, 'Board'))
					$board = $object->get_board();
				else
					$board = $object;

				if (isset($object->secret) && $object->secret &&
					$action == 'edit')
					return ASK_PASSWORD;
				else if (isset($object->user_id) && $object->user_id == 0)
					// edit 액션일 때는 고치기 폼에서 암호를 입력함.
					return $action == 'edit' ? true : ASK_PASSWORD;
				else
					return false;
			break;
			case 'reply':
			case 'comment':
				$board = $object->get_board();
				return ($board->restrict_comment() && $board->is_member($this) && $this->level >= $board->perm_comment)
					|| (!$board->restrict_comment() && $this->level >= $board->perm_comment);
			break;
		}
	}
}
?>
