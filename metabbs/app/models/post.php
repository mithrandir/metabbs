<?php
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
	var $tags = '';

	function _init() {
		$this->table = get_table_name('post');
		$this->board_table = get_table_name('board');
		$this->user_table = get_table_name('user');
		$this->category_table = get_table_name('category');
		$this->comment_table = get_table_name('comment');
		$this->attachment_table = get_table_name('attachment');
		$this->tag_table = get_table_name('tag');
		$this->tag_post_table = get_table_name('tag_post');

		$this->trackback_rel = new OneToManyRelation($this, 'trackback');
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
		return $this->category_id ? find('category', $this->category_id) : null;
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


	// 트랙백 관련
	function get_trackbacks() {
		return $this->trackback_rel->all();
	}
	function add_trackback($trackback) {
		$this->trackback_rel->add($trackback);
	}
	function get_trackback_count() {
		return $this->trackback_rel->count();
	}


	function update_attachment_count() {
		$this->attachment_count = $this->get_attachment_count();
		$this->db->execute("UPDATE $this->table SET attachment_count=$this->attachment_count WHERE id=$this->id");
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
	function get_tags() {
		return $this->db->fetchall("SELECT t.* FROM $this->tag_post_table AS tp INNER JOIN $this->tag_table AS t ON tp.post_id = $this->id AND tp.tag_id = t.id ORDER BY created_at ASC", 'Tag');
	}
	function get_tag_count() {
		return $this->db->fetchone("SELECT COUNT(*) FROM $this->tag_post_table AS tp INNER JOIN $this->tag_table AS t ON tp.post_id = $this->id AND tp.tag_id = t.id ORDER BY created_at ASC", 'Tag');
	}
	function find_tag_by_name($name) {
		return $this->db->fetchrow("SELECT * FROM $this->tag_table WHERE board_id = ? AND name = ? LIMIT 1", 'Tag', array($this->board_id, $this->db->escape($name)));
	}
	function add_tag_by_name($name) {
		$tag = Tag::find_by_name($name);
		if (!$tag->exists()) {
			unset($tag);
			$tag = new Tag(array('name'=>$name, 'board_id'=>$this->board_id));
			$tag->create();
		} 
		$tag->relate_to_post($this);
		return true;
	}
	function delete_tag_by_name($name) {
		$tag = Tag::find_by_name($name);
		if (!$tag->exists()) return false;

		$tag->unrelate_to_post($this);
		return true;
	}
	function arrange_tags_after_create() {
		$tags = array();

		if ($this->tags != '')
			foreach (array_trim(explode(',', $this->tags)) as $tag_name)
				if ($tag_name != '' && $this->add_tag_by_name($tag_name))
					array_push($tags, $tag_name);

		if (count($tags) > 0) {
			$this->db->execute("UPDATE $this->table SET tags='".$this->db->escape(implode(',', $tags))."', tag_count = ".count($tags)." WHERE id=$this->id");
		}
	}
	function arrange_tags_after_update() {
		$old_tags = array();

		foreach ($this->get_tags() as $tag)
			array_push($old_tags, $tag->name);
	
		$new_tags = $this->tags == '' ? array() : array_trim(explode(',', $this->tags));

		$atags = $old_tags == '' ? $new_tags : ($new_tags == '' ? array() : array_diff($new_tags, $old_tags));
		$dtags = $new_tags == '' ? $old_tags : ($old_tags == '' ? array() : array_diff($old_tags, $new_tags));
		$tags = array_intersect($old_tags, $new_tags);

		foreach ($atags as $tag_name)
			if ($tag_name != '' && $this->add_tag_by_name($tag_name))
				array_push($tags, $tag_name);

		foreach ($dtags as $tag_name)
			if ($tag_name != '')
				$this->delete_tag_by_name($tag_name);
		
		if (count($tags) > 0) {
			$this->db->execute("UPDATE $this->table SET tags='".$this->db->escape(implode(',', $tags))."', tag_count = ".count($tags)." WHERE id=$this->id");
		}
	}
	function delete() {
		$this->db->execute("DELETE FROM $this->table WHERE moved_to=$this->id");
		$this->db->execute("DELETE FROM $this->comment_table WHERE post_id=$this->id");
		$this->trackback_rel->clear();
		foreach($this->get_tags() as $tag)
				$this->delete_tag_by_name($tag->name);
		apply_filters('PostDelete', $this);
		Model::delete();
	}
	function update_view_count($point = 1) {
		$this->views = $this->views + $point;
		$this->db->execute("UPDATE $this->table SET views=views+{$point}, created_at='$this->created_at' WHERE id=$this->id");
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
		return $this->name != '' && $this->title != '' && $this->body != '';
	}
	function move_to($board, $track = true) {
		$_id = $this->id;
		$attributes = $this->get_attributes();
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
		$this->trackback_rel->update(array('post_id' => $this->id));
		$this->db->execute("UPDATE $this->attachment_table SET post_id=$this->id WHERE post_id=$_id");
		$this->metadata->reload();
		foreach ($attributes as $key => $value)
			$this->set_attribute($key, $value);
	}
	function get_page() {
		$board = $this->get_board();
		$query = "SELECT COUNT(*) FROM $this->table WHERE board_id=$board->id AND (sort_key < $this->sort_key OR sort_key = $this->sort_key AND id > $this->id)";
		return 1 + floor($this->db->fetchone($query)/$board->posts_per_page);
	}
}
?>
