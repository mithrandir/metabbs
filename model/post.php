<?php
class Post extends Model {
	var $model = 'post';

	var $name, $title, $type = 0, $body;
	var $secret = 0;
	var $category_id;

	function _init() {
		$this->table = get_table_name('post');
		$this->board_table = get_table_name('board');
		$this->user_table = get_table_name('user');
		$this->category_table = get_table_name('category');
		$this->comment_table = get_table_name('comment');
		$this->trackback_table = get_table_name('trackback');
		$this->attachment_table = get_table_name('attachment');
	}
	function find($id) {
		$db = get_conn();
		$table = get_table_name('post');
		return $db->fetchrow("SELECT * FROM $table WHERE id=?", 'Post', array($id));
	}
	function create() {
		$this->password = md5($this->password);
		Model::create();
	}
	function update() {
		unset($this->created_at);
		Model::update();
	}
	function is_notice() {
		return $this->type == 1;
	}
	function get_board() {
		return Board::find($this->board_id);
	}
	function get_board_name() {
		$board = $this->get_board();
		return $board->get_title();
	}
	function get_user() {
		if (!isset($this->user))
			$this->user = User::find($this->user_id);
		return $this->user;
	}
	function get_category() {
		return $this->category_id ? Category::find($this->category_id) : null;
	}
	function get_comments() {
		$_comments = $this->db->fetchall("SELECT * FROM $this->comment_table WHERE post_id=$this->id ORDER BY id", 'Comment', array(), true);
		$comments = array();
		foreach ($_comments as $id => $comment) {
			if ($comment->parent) {
				$_comments[$comment->parent]->comments[] = &$_comments[$id];
				//echo 'adding child ('.$id.'->'.$comment->parent.')<br>';
			} else {
				$comments[] = &$_comments[$id];
				//echo 'adding root comment ('.$id.')<br>';
			}
		}
		return $comments;
	}
	function add_comment(&$comment) {
		$comment->board_id = $this->board_id;
		$comment->post_id = $this->id;
		$comment->create();
	}
	function get_comment_count() {
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->comment_table WHERE post_id=$this->id");
	}
	function get_trackbacks() {
		return $this->db->fetchall("SELECT * FROM $this->trackback_table WHERE post_id=$this->id", 'Trackback');
	}
	function add_trackback($trackback) {
		$trackback->post_id = $this->id;
		$trackback->create();
	}
	function get_trackback_count() {
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->trackback_table WHERE post_id=$this->id");
	}
	function get_attachments() {
		return $this->db->fetchall("SELECT * FROM $this->attachment_table WHERE post_id=$this->id", 'Attachment');
	}
	function add_attachment(&$attachment) {
		$attachment->post_id = $this->id;
		$attachment->create();
	}
	function get_attachment_count() {
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->attachment_table WHERE post_id=$this->id");
	}
	function delete() {
		Model::delete();
		$this->db->query("DELETE FROM $this->comment_table WHERE post_id=$this->id");
		$this->db->query("DELETE FROM $this->trackback_table WHERE post_id=$this->id");
	}
	function update_view_count() {
		$this->views++;
		$this->db->query("UPDATE $this->table SET views=views+1, created_at='$this->created_at' WHERE id=$this->id");
	}
}
?>
