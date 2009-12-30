<?php
class User extends Model {
	var $model = 'user';
	var $user, $name;
	var $email, $url;
	var $level = 1;
	var $token;
	var $signature = '';
	function _init() {
		$this->table = get_table_name('user');
		$this->post_table = get_table_name('post');
		$this->comment_table = get_table_name('comment');
	}
	function delete() {
		apply_filters('UserDelete', $this);
		Model::delete();
	}
	function find($id) {
		$db = get_conn();
		$table = get_table_name('user');
		return $db->fetchrow("SELECT * FROM $table WHERE id=?", 'User', array($id));
	}
	function get_posts($offset = 0, $limit = null, $order_by = 'id DESC') {
		return $this->db->fetchall("SELECT * FROM $this->post_table WHERE user_id=$this->id ".($order_by ? " ORDER BY $order_by":'').($limit ? " LIMIT".($offset != 0 ? " $offset, ":'').' '.$limit : ''), 'Post');
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
	function find_all($offset = 0, $limit = null, $order_by = 'id DESC') {
		$db = get_conn();
		$table = get_table_name('user');
		return $db->fetchall("SELECT * FROM $table".($order_by ? " ORDER BY $order_by":'').($limit ? " LIMIT".($offset != 0 ? " $offset, ":'').' '.$limit : ''), 'User');
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
	function validate_before_create(&$error_messages) {
		if (strlen($this->user) < 5 or strlen($this->user) > 45)
			$error_messages->add('User ID length must be longer than 5 and shorter than 45', 'user');

		if (!Validate::identifier($this->user))
			$error_messages->add('User ID must be composed of the characters \'a-zA-Z0-9_-\'', 'user');

		if (in_array($this->user, array('account','openid','board','post','comment','attachment', 'user')))
			$error_messages->add('User ID may not be some reserved words(account, user, openid.. etc.)', 'user');

		$user = User::find_by_user($this->user);
		if ($user->exists())
			$error_messages->add('User ID already exists', 'user');

		if (strlen($this->password) < 5)
			$error_messages->add('Password length must be longer than 5', 'password');

		if ($this->password != $this->password_again)
			$error_messages->add('Two password fields\' content must be same', 'password_again');

		if (strlen($this->email) == 0)
			$error_messages->add('Please enter a E-Mail address', 'email');
			
		if (strlen($this->email) > 255 && !Validate::email($this->email))
			$error_messages->add('Please enter a valid E-Mail address', 'email');

		if (!empty($this->url)) {
			if (strlen($this->url) > 255)
				$error_messages->add('Please enter a homepage address shorter than 255 characters', 'url');
			if (!Validate::url($this->url))
				$error_messages->add('Please enter a valid homepage address', 'url');
		}
	}
	function validate_before_update(&$error_messages) {
		if (!empty($this->password) && strlen($this->password) < 5)
			$error_messages->add('Password length must be longer than 5', 'password');

		if (strlen($this->email) == 0)
			$error_messages->add('Please enter a E-Mail address', 'email');
			
		if (strlen($this->email) > 255 || !Validate::email($this->email))
			$error_messages->add('Please enter a valid E-Mail address', 'email');
			
		if (!empty($this->url)) {
			if (strlen($this->url) > 255)
				$error_messages->add('Please enter a homepage address shorter than 255 characters', 'url');
			if (!Validate::url($this->url))
				$error_messages->add('Please enter a valid homepage address', 'url');
		}
	}
	function validate_before_transfer(&$error_messages) {
		if (strlen($this->user) < 5 or strlen($this->user) > 45)
			$error_messages->add('User ID length must be longer than 5 and shorter than 45', 'user');

		if (!Validate::identifier($this->user))
			$error_messages->add('User ID must be composed of the characters \'a-zA-Z0-9_-\'', 'user');

		if (in_array($this->user, array('account','openid','board','post','comment','attachment', 'user')))
			$error_messages->add('User ID may not be some reserved words(account, user, openid.. etc.)', 'user');

		$user = User::find_by_user($this->user);
		if ($user->exists())
			$error_messages->add('User ID already exists', 'user');

		if (strlen($this->password) < 5)
			$error_messages->add('Password length must be longer than 5', 'password');

		if ($this->password != $this->password_again)
			$error_messages->add('Two password fields\' content must be same', 'password_again');
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
	function is_openid_account() {
		return $this->password == 'openid';
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
				if ($board->get_attribute('always_show_comments', false))
					return true;

				if ($this->level < $board->perm_comment)
					return false;

				if ($board->restrict_comment())
					return $board->is_member($this);
				else
					return true;
			break;
			case 'write_comment':
				$board = $object->get_board();
				return ($board->restrict_comment())
					|| (!$board->restrict_comment() and !$board->get_attribute('always_show_comments', false) );
			break;
			case 'attachment':
				if ($this->level < $board->perm_attachment)
					return false;

				if ($board->restrict_attachment())
					return $board->is_member($this);
				else
					return true;
			break;
			case 'thumbnail':
				$board = $object->get_board();
				return $board->get_attribute('always_show_thumbnail', false)
					|| !$board->get_attribute('always_show_thumbnail', false)
					&& (($board->restrict_attachment() && $board->is_member($this) && $this->level >= $board->perm_attachment)
						|| (!$board->restrict_attachment() && $this->level >= $board->perm_attachment));
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
	function delete() {
		apply_filters('UserDelete', $this);
		Model::delete();
	}
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
					|| ($object->restrict_access() && $object->is_member($this) && $this->level >= $object->perm_read)
					|| (!$object->restrict_access() && $this->level >= $object->perm_read);
			break;
			case 'read':
				$board = $object->get_board();
				if ($object->secret) {
					if ($object->user_id == 0)
						return ASK_PASSWORD;
					else
						return false;
				}
				return ($board->restrict_access() && $board->is_member($this) && $this->level >= $board->perm_read)
					|| (!$board->restrict_access() && $this->level >= $board->perm_read);

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
				else if (!isset($object->user_id) || $object->user_id == 0)
					// edit 액션일 때는 고치기 폼에서 암호를 입력함.
					return $action == 'edit' ? true : ASK_PASSWORD;
				else
					return false;
			break;
			case 'reply':
			case 'comment':
				$board = $object->get_board();
				return $board->get_attribute('always_show_comments', false)
					|| ($board->restrict_comment() && $board->is_member($this) && $this->level >= $board->perm_comment)
					|| (!$board->restrict_comment() && $this->level >= $board->perm_comment);
			break;
			case 'write_comment':
				$board = $object->get_board();
				return ($board->restrict_comment())
					|| (!$board->restrict_comment() and !$board->get_attribute('always_show_comments', false) );
			break;
			case 'attachment':
				$board = $object->get_board();
				return ($board->restrict_attachment() && $board->is_member($this) && $this->level >= $board->perm_attachment)
					|| (!$board->restrict_attachment() && $this->level >= $board->perm_attachment);
			break;
			case 'thumbnail':
				$board = $object->get_board();
				return $board->get_attribute('always_show_thumbnail', false)
					|| !$board->get_attribute('always_show_thumbnail', false)
					&& (($board->restrict_attachment() && $board->is_member($this) && $this->level >= $board->perm_attachment)
						|| (!$board->restrict_attachment() && $this->level >= $board->perm_attachment));
			break;
		}
	}
}
?>
