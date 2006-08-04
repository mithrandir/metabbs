<?php
class Comment extends Model {
	function find($id) {
		return model_find('comment', $id);
	}
	function get_board() {
		$post = $this->get_post();
		return $post->get_board();
	}
	function get_post() {
		return Post::find($this->post_id);
	}
	function create() {
		if (isset($this->password))
			$this->password = md5($this->password);
		$this->created_at = model_datetime();
		Model::create();
	}
	function get_user() {
		if ($this->user_id) {
			return User::find($this->user_id);
		} else {
			return new Guest(array('name' => $this->name));
		}
	}
}
?>
