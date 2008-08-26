<?php
class Tag extends Model {
	var $model = 'tag';
	var $name;
	var $post_count;

	function _init() {
		$this->table = get_table_name('tag');
		$this->post_table = get_table_name('post');
		$this->tag_post_table = get_table_name('tag_post');
	}
	function find($id) {
		return find('tag', $id);
	}
	function create() {
		$this->post_count = 1;
		$this->updated_at = time();
		Model::create();
	}
	function update() {
		$this->updated_at = time();
		Model::update();
	}
	function delete() {
		Model::delete();
	}
	function add_tag_post($post) {
		$this->create();
		$this->db->execute("INSERT INTO $this->tag_post_table (post_id, tag_id, created_at) VALUES($post->id, $this->id, ".time().")");
	}
	function increase_tag_post($post) {
		$tag = $this->db->fetchrow("SELECT t.* FROM $this->tag_post_table AS tp INNER JOIN $this->table AS t ON tp.post_id = $post->id AND tp.tag_id = t.id AND t.name = '$this->name' AND board_id = $post->board_id LIMIT 1", 'tag');
		if ($tag->exists()) return false;  

		$this->db->execute("INSERT INTO $this->tag_post_table (post_id, tag_id, created_at) VALUES($post->id, $this->id, ".time().")");
		$this->post_count++;
		$this->update();

		return true;
	}
	function delete_tag_post($post) {
		$this->db->execute("DELETE FROM $this->tag_post_table WHERE post_id = $post->id AND tag_id = $this->id");
		$this->post_count--;
		$this->update();

		if ($this->post_count < 1) 
			$this->delete();
	}
}
?>