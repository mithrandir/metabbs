<?php
require_once dirname(__FILE__) . "/post_meta.php";

class Post extends Model {
	var $model = 'post';

	var $name, $title, $notice = false, $body;
	var $user_id = 0;
	var $secret = 0;
	var $category_id = 0;
	var $views = 0;
	var $edited_by = 0;
	var $moved_to = 0;
	var $comment_count = 0;
	var $sort_key = 0;
	var $meta = array();

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
		return find('post', $id);
	}
	function create() {
		$this->password = md5($this->password);
		$this->created_at = time();
		$this->edited_at = 0;
		$this->last_update_at = $this->created_at;
		Model::create();
		$this->update_sort_key();

		foreach ($this->meta as $k => $v)
			$this->set_attribute($k, $v);
	}
	function update() {
		$this->edited_at = time();
		Model::update();
		$this->update_sort_key();
	}
	function update_sort_key() {
		if ($this->notice) {
			$this->db->execute("UPDATE $this->table SET sort_key=-id WHERE id=$this->id");
		} else {
			$board = $this->get_board();
			if (!$board->order_by) $board->order_by = 'id DESC';
			preg_match('/^(.+?) (ASC|DESC)?$/', $board->order_by, $matches);
			list(, $key, $order) = $matches;
			if ($order == 'DESC')
				$this->db->execute("UPDATE $this->table SET sort_key=2147483648-$key WHERE id=$this->id");
			else
				$this->db->execute("UPDATE $this->table SET sort_key=$key WHERE id=$this->id");
		}
	}
	function is_notice() {
		return (bool) $this->notice;
	}
	function is_edited() {
		return $this->edited_at != 0;
	}
	function get_board() {
		return find('board', $this->board_id);
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
		
		if ($this->category_id==0) {
		 	 find('category', $this->category_id);
		} else {
		 null;
		}
	}
	function get_comments($build_tree = true) {
		$_comments = $this->db->fetchall("SELECT * FROM $this->comment_table WHERE post_id=$this->id ORDER BY id", 'Comment', array(), $build_tree);
		if ($build_tree) {
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
		} else {
			return $_comments;
		}
	}
	function add_comment(&$comment) {
		$comment->board_id = $this->board_id;
		$comment->post_id = $this->id;
		$comment->create();
		$this->db->execute("UPDATE $this->table SET last_update_at=$comment->created_at WHERE id=$this->id");
		$this->update_sort_key();
	}
	function get_real_comment_count() {
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->comment_table WHERE post_id=$this->id AND user_id != -1");
	}
	function get_comment_count() {
		return $this->comment_count;
	}
	function update_comment_count() {
		$this->comment_count = $this->get_real_comment_count();
		$this->db->execute("UPDATE $this->table SET comment_count=$this->comment_count WHERE id=$this->id");
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
		$this->db->execute("DELETE FROM $this->table WHERE moved_to=$this->id");
		$this->db->execute("DELETE FROM $this->comment_table WHERE post_id=$this->id");
		$this->db->execute("DELETE FROM $this->trackback_table WHERE post_id=$this->id");
	}
	function update_view_count() {
		$this->views++;
		$this->db->execute("UPDATE $this->table SET views=views+1, created_at='$this->created_at' WHERE id=$this->id");
	}
	function update_category() {
		$this->db->execute("UPDATE $this->table SET category_id=$this->category_id WHERE id=$this->id");
	}
	function get_newer_post() {
		return $this->db->fetchrow("SELECT * FROM $this->table WHERE board_id=$this->board_id AND (sort_key < $this->sort_key OR sort_key = $this->sort_key AND id > $this->id) ORDER BY sort_key DESC, id LIMIT 1", 'Post');
	}
	function get_older_post() {
		return $this->db->fetchrow("SELECT * FROM $this->table WHERE board_id=$this->board_id AND (sort_key > $this->sort_key OR sort_key = $this->sort_key AND id < $this->id) ORDER BY sort_key, id DESC LIMIT 1", 'Post');
	}
	function valid() {
		return !empty($this->name) && !empty($this->title) && !empty($this->body);
	}
	function move_to($board, $track = true) {
		$_id = $this->id;
		$this->id = null;
		$this->category_id = 0;
		$this->board_id = $board->id;
		$this->create();
		$this->db->execute("DELETE FROM $this->table WHERE moved_to=$_id");
		if ($track)
			$this->db->execute("UPDATE $this->table SET moved_to=$this->id WHERE id=$_id");
		else
			$this->db->execute("DELETE FROM $this->table WHERE id=$_id");
		$this->db->execute("UPDATE $this->comment_table SET post_id=$this->id WHERE post_id=$_id");
		$this->db->execute("UPDATE $this->trackback_table SET post_id=$this->id WHERE post_id=$_id");
		$this->db->execute("UPDATE $this->attachment_table SET post_id=$this->id WHERE post_id=$_id");
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
		$this->metadata->post = &$this; // workaround for PHP4 -_-
		$this->metadata->set($key, $value);
	}
	function get_page() {
		$board = $this->get_board();
		$query = "SELECT COUNT(*) FROM $this->table WHERE board_id=$board->id AND (sort_key < $this->sort_key OR sort_key = $this->sort_key AND id > $this->id)";
		return 1 + floor($this->db->fetchone($query)/$board->posts_per_page);
	}
}
?>
