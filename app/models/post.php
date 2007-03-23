<?php
class PostMeta {
	function PostMeta(&$post) {
		$this->post = $post;
		$this->db = get_conn();
		$this->table = get_table_name('post_meta');
		$this->attributes = array();
		$this->loaded = false;
	}
	function load() {
		if ($this->loaded) return;
		$result = $this->db->get_result("SELECT * FROM $this->table WHERE post_id={$this->post->id}");
		while ($data = $result->fetch()) {
			$this->attributes[$data['key']] = $data['value'];
		}
	}
	function get($key) {
		return $this->attributes[$key];
	}
	function set($key, $value) {
		if (!array_key_exists($key, $this->attributes)) {
			$this->db->query("INSERT INTO $this->table (post_id, `key`, value) VALUES({$this->post->id}, ?, ?)", array($key, $value));
		} else {
			$this->db->query("UPDATE $this->table SET value=? WHERE post_id={$this->post->id} AND `key`=?", array($value, $key));
		}
		$this->attributes[$key] = $value;
	}
	function reset() {
		$this->db->query("DELETE FROM $this->table WHERE post_id={$this->post->id}");
	}
}

class Post extends Model {
	var $model = 'post';

	var $name, $title, $type = 0, $body;
	var $user_id = 0;
	var $secret = 0;
	var $category_id = 0;
	var $views = 0;
	var $edited_by = 0;
	var $moved_to = 0;

	function _init() {
		$this->table = get_table_name('post');
		$this->board_table = get_table_name('board');
		$this->user_table = get_table_name('user');
		$this->category_table = get_table_name('category');
		$this->comment_table = get_table_name('comment');
		$this->trackback_table = get_table_name('trackback');
		$this->attachment_table = get_table_name('attachment');

		$this->metadata = new PostMeta($this);
	}
	function find($id) {
		$db = get_conn();
		$table = get_table_name('post');
		return $db->fetchrow("SELECT * FROM $table WHERE id=?", 'Post', array($id));
	}
	function create() {
		$this->password = md5($this->password);
		$this->created_at = time();
		$this->edited_at = 0;
		Model::create();
	}
	function update() {
		$this->edited_at = time();
		Model::update();
	}
	function is_notice() {
		return $this->type == 1;
	}
	function is_edited() {
		return $this->edited_at != 0;
	}
	function get_board() {
		return Board::find($this->board_id);
	}
	function get_board_name() {
		$board = $this->get_board();
		return $board->get_title();
	}
	function get_user() {
		if ($this->user_id) {
			if (!isset($this->user))
				$this->user = User::find($this->user_id);
			return $this->user;
		} else {
			return new Guest(array('name' => $this->name));
		}
	}
	function get_editor() {
		if ($this->edited_by) {
			return User::find($this->edited_by);
		} else {
			return new Guest(array('name' => $this->name));
		}
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
	function get_newer_post() {
		return $this->db->fetchrow("SELECT * FROM $this->table WHERE board_id=$this->board_id AND id > $this->id ORDER BY id ASC LIMIT 1", 'Post');
	}
	function get_older_post() {
		return $this->db->fetchrow("SELECT * FROM $this->table WHERE board_id=$this->board_id AND id < $this->id ORDER BY id DESC LIMIT 1", 'Post');
	}
	function valid() {
		return !empty($this->name) && !empty($this->title) && !empty($this->body);
	}
	function move_to($board) {
		$_id = $this->id;
		$this->id = null;
		$this->category_id = 0;
		$this->board_id = $board->id;
		$this->create();
		$this->db->query("UPDATE $this->table SET moved_to=$this->id WHERE id=$_id");
	}
	function get_attribute($key) {
		if ($this->exists()) $this->metadata->load();
		return $this->metadata->get($key);
	}
	function get_attributes() {
		if ($this->exists()) $this->metadata->load();
		return $this->metadata->attributes;
	}
	function set_attribute($key, $value) {
		$this->metadata->set($key, $value);
	}
}
?>
