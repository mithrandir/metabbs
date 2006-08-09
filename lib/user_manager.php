<?php
class UserManager
{
	function get_user() {
		if (cookie_is_registered('user') && cookie_is_registered('password')) {
			return User::auth(cookie_get('user'), cookie_get('password'));
		} else {
			return null;
		}
	}
	function login($user, $password) {
		$user = User::auth($user, md5($password));
		if ($user->exists()) {
			cookie_register("user", $user->user);
			cookie_register("password", $user->password);
			return true;
		} else {
			return false;
		}
	}
	function logout() {
		if (UserManager::get_user()) {
			cookie_unregister('user');
			cookie_unregister('password');
			return true;
		} else {
			return false;
		}
	}
	function signup($user_id, $password, $name, $email, $url) {
		$user = new User;
		$user->user = $user_id;
		$user->password = md5($password);
		$user->name = $name;
		$user->email = $email;
		$user->url = $url;

		if ($user->valid()) {
			$user->create();
			return $user;
		} else {
			return null;
		}
	}
}

class User extends Model {
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
	function get_posts() {
		return $this->db->fetchall("SELECT * FROM $this->post_table WHERE user_id=$this->id", 'Post');
	}
	function add_post($post) {
		$post->user_id = $this->id;
		$post->create();
	}
	function get_post_count() {
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->post_table WHERE user_id=$this->id");
	}
	function get_comments() {
		return $this->db->fetchall("SELECT * FROM $this->comment_table WHERE user_id=$this->id", 'Comment');
	}
	function add_comment($comment) {
		$comment->user_id = $this->id;
		$comment->create();
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
}
?>
