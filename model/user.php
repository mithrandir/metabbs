<?php
class User extends Model {
	var $model = 'user';

	var $email, $url;
	var $level = 1;
	var $posts_per_page = 10;
	function _init() {
		$this->table = get_table_name('user');
		$this->post_table = get_table_name('post');
		$this->comment_table = get_table_name('comment');
	}
	function find($id) {
		$db = get_conn();
		$table = get_table_name('user');
		return $db->fetchrow("SELECT * FROM $table WHERE id=$id", 'User');
	}
	function get_posts($offset, $limit) {
		return $this->db->fetchall("SELECT *, created_at+0 as created_at FROM $this->post_table WHERE user_id=$this->id ORDER BY id DESC LIMIT $offset, $limit", 'Post');
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
		$user = $db->fetchrow("SELECT * FROM $table WHERE user='$user' AND password='$password'", 'User');
		if ($user->exists()) {
			return $user;
		} else {
			return new Guest;
		}
	}
	function find_by_user($user) {
		$db = get_conn();
		$table = get_table_name('user');
		return $db->fetchrow("SELECT * FROM $table WHERE user='$user'", 'User');
	}
	function find_all() {
		$db = get_conn();
		$table = get_table_name('user');
		return $db->fetchall("SELECT * FROM $table", 'User');
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
}
?>
