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
			$user->save();
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
	function auth($user, $password) {
		$user = model_find('user', null, "user='$user' AND password='$password'");
		if ($user->exists()) {
			return $user;
		} else {
			return new Guest;
		}
	}
	function find($id) {
		if ($id) {
			return model_find('user', $id);
		}
		else {
			return new Guest;
		}
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
		return model_count('post', "user_id=$this->id");
	}
	function get_comment_count() {
		return model_count('comment', "user_id=$this->id");
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
	function is_admin() {
		return $this->level == 255;
	}
	function valid() {
		$user = User::find_by_user($this->user);
		return !$user->exists();
	}
}
?>
