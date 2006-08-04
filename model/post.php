<?php
model('comment');
model('attachment');
model('trackback');

class Post extends Model {
	var $title, $body;
	var $user_id = 0;
	var $type = 0;
	var $category_id = 0;
	
	function _init() {
		$this->board = $this->belongs_to('board');
		$this->category = $this->belongs_to('category');
		$this->comments = $this->has_many('comment');
		$this->trackbacks = $this->has_many('trackback');
		$this->attachments = $this->has_many('attachment');
	}
	function get_user() {
		$user = User::find($this->user_id);
        if ($user->is_guest()) {
            $user->name = $this->name;
        }
        return $user;
	}
	function get_board() {
		return $this->board->find();
	}
	function get_category() {
		return $this->category->find();
	}
	function get_board_name() {
		$board = $this->get_board();
		return $board->get_title();
	}
	function create() {
		if (isset($this->password))
			$this->password = md5($this->password);
		Model::create();
	}
	function update() {
		$this->created_at = null;
		Model::update();
	}
	function delete() {
		Model::delete();
		$this->comments->clear();
		$this->trackbacks->clear();
		$this->attachments->clear();
	}
	function get_comments() {
		return $this->comments->find_all();
	}
	function get_comment_count() {
		return $this->comments->count();
	}
	function get_trackbacks() {
		return $this->trackbacks->find_all();
	}
	function get_trackback_count() {
		return $this->trackbacks->count();
	}
	function get_attachments() {
		return $this->attachments->find_all();
	}
	function is_notice() {
		return ($this->type == 1);
	}
}
?>
