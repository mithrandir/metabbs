<?php
model('post');
model('user');
model('category');

class Board extends Model {
	var $count;
	var $name, $title;
	var $skin = 'default';
	var $posts_per_page = 10;
	var $use_attachment = 0;
	var $use_category = 0;
	var $searchtype = '';
	var $search = '';
	var $category = null;
	var $perm_read = 0;
	var $perm_write = 0;
	var $perm_comment = 0;
	var $perm_delete = 255;

	function _init() {
		$this->categories = $this->has_many('category');
	}
	function get_id() {
		return $this->name;
	}
	function find_by_name($name) {
		return model_find('board', null, "name='$name'");
	}
	function find($id) {
		return model_find('board', $id);
	}
	function find_all() {
		return model_find_all('board');
	}
	function get_where() {
        	if ($this->searchtype) {
			$searchtype = $this->searchtype;
		}
		else {
			$searchtype = 'tb';
		}
		$search = '%' . $this->search . '%';
		if ($searchtype == 'tb') {
			return "(title LIKE '$search' OR body LIKE '$search')";
		}
		else if ($searchtype == 't') {
			return "title LIKE '$search'";
		}
		else if ($searchtype == 'b') {
			return "body LIKE '$search'";
		}
	}
	function get_posts($offset, $limit) {
		$where = "board_id=$this->id";
		if ($this->search) {
			$where .= " AND " . $this->get_where();
		}
		if ($this->category) {
			$where .= " AND category_id=" . $this->category;
		}
		return model_find_all('post', $where, 'type DESC, id DESC', $offset, $limit);
	}
	function get_feed_posts($count) {
		return model_find_all('post', 'board_id='.$this->id, 'id DESC', 0, $count);
	}
	function get_categories() {
		return $this->categories->find_all();
	}
	function get_post_count() {
		if (!$this->count) {
			$where = "board_id=$this->id";
			if ($this->search) {
				$where .= " AND " . $this->get_where();
			}
			$this->count = model_count('post', $where);
		}
		return $this->count;
	}
	function validate() {
		$board = Board::find_by_name($this->name);
		return !$board->exists();
	}
	function delete() {
		model_delete('board', 'id='.$this->id);
		$posts = model_find_all('post', 'board_id='.$this->id);
		foreach ($posts as $post) {
			$post->delete();
		}
	}
	function get_title() {
		if ($this->title) {
			return $this->title;
		} else {
			return $this->name;
		}
	}
}
?>
