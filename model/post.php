<?php
class Post extends Model {
	var $name, $title, $type = 0, $body;
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
		return $db->fetchrow("SELECT * FROM $table WHERE id=$id", 'Post');
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
		return User::find($this->user_id);
	}
	function get_category() {
		return $this->category_id ? Category::find($this->category_id) : null;
	}
	function get_comments() {
		return $this->db->fetchall("SELECT * FROM $this->comment_table WHERE post_id=$this->id", 'Comment');
	}
	function add_comment(&$comment) {
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
}
?>
