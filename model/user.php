<?php
class User extends Model {
	var $email, $url;
	var $level = 1;
	var $posts_per_page = 10;
	function auth($user, $password) {
		$user = model_find('user', null, "user='$user' AND password='$password'");
		if ($user->exists()) {
			return $user;
		} else {
			return new Guest;
		}
	}
	function find($id) {
		return model_find('user', $id);
	}
	function find_by_user($user) {
		return model_find('user', null, "user='$user'");
	}
	function find_all() {
		return model_find_all('user');
	}
	function get_posts($offset, $limit) {
		$where = "user_id=$this->id";
		return model_find_all('post', $where, 'id DESC', $offset, $limit);
	}
	function get_post_count() {
		$where = "user_id=$this->id";
		return model_count('post', $where);
	}
	function create() {
		model_insert('user', array(
			'user' => $this->user,
			'password' => $this->password,
			'name' => $this->name,
			'email' => $this->email,
			'url' => $this->url,
			'level' => $this->level));
	}
	function update() {
		model_update('user', array(
			'password' => $this->password,
			'name' => $this->name,
			'email' => $this->email,
			'url' => $this->url,
			'level' => $this->level),
		'id='.$this->id);
	}
	function delete() {
		model_delete('user', 'id='.$this->id);
	}
	function is_guest() {
		return false;
	}
	function valid() {
		$user = User::find_by_user($this->user);
		return !$user->exists();
	}
}

class Guest extends Model
{
	var $id = 0;
	var $level = 0;
	var $name, $email, $url;
	function is_guest() {
		return true;
	}
}
?>
