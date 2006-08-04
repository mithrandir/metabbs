<?php
model('comment');
model('attachment');
model('trackback');

class Post extends Model {
	var $id, $count;
	var $title, $body;
	var $user_id = 0;
	var $type = 0;
	var $category_id = 0;
	var $tb_count;
	
	function get_user() {
		$user = User::find($this->user_id);
        if ($user->is_guest()) {
            $user->name = $this->name;
        }
        return $user;
	}
	function get_board() {
		return Board::find($this->board_id);
	}
	function get_category() {
		if ($this->category_id) {
			return Category::find($this->category_id);
		} else {
			return null;
		}
	}
	function get_board_name() {
		$board = $this->get_board();
		if ($board->title) {
			return $board->title;
		} else {
			return $board->name;
		}
	}
	function find($id) {
		return model_find('post', $id);
	}
	function create() {
		if (isset($this->password))
			$this->password = md5($this->password);
		Model::create();
	}
	function update() {
		model_update('post', array(
			'name'	   => $this->name,
			'title'	  => $this->title,
			'type' => $this->type,
			'body'	   => $this->body,
			'category_id' => $this->category_id,
			'created_at' => model_datetime()), 'id='.$this->id);
	}
	function delete() {
		model_delete('post', 'id='.$this->id);
		model_delete('comment', 'post_id='.$this->id);
		model_delete('trackback', 'post_id='.$this->id);
		model_delete('attachment', 'post_id='.$this->id);
	}
	function get_comments() {
		return model_find_all('comment', 'post_id='.$this->id);
	}
	function get_comment_count() {
		if (!$this->count) {
			$this->count = model_count('comment', 'post_id='.$this->id);
		}
		return $this->count;
	}
	function get_trackback_count() {
		if (!$this->tb_count) {
			$this->tb_count = model_count('trackback', 'post_id='.$this->id);
		}
		return $this->tb_count;
	}
	function get_attachments() {
		return model_find_all('attachment', 'post_id='.$this->id);
	}
	function get_trackbacks() {
		return model_find_all('trackback', 'post_id='.$this->id);
	}
	function is_notice() {
		return ($this->type == 1);
	}
}
?>
