<?php
class User extends Model {
	var $model = 'user';

	var $email, $url;
	var $level = 1;
	var $token;
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
	function is_owner_of($model) {
		return $model->user_id == $this->id;
	}
	function set_token($token) {
		$this->db->query("UPDATE $this->table SET token='$token' WHERE id=$this->id");
	}
	function unset_token() {
		$this->set_token('');
	}
	function has_perm($perm, $object) {
		return authz_has_perm($this, $perm, $object);
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
	function has_perm($perm, $object) {
		return authz_has_perm($this, $perm, $object);
	}
}
?>
