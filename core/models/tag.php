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
	function find_by_name($name) {
		return find_by('tag', 'name', $name);
	}
	function create() {
		$this->updated_at = time();
		Model::create();
	}
	function update() {
		$this->updated_at = time();
		Model::update();
	}
	function add_tag_post($post) {
		$this->create();
		$this->db->execute("INSERT INTO $this->tag_post_table (post_id, tag_id, created_at) VALUES($post->id, $this->id, ".time().")");
	}
	function relate_to_post($post) {
		$tag_post = TagPost::find_by_tag_and_post($this, $post);
		if(!$tag_post->exists()) {
			unset($tag_post);
			$tag_post = new TagPost(array('tag_id' => $this->id, 'post_id' => $post->id));
			$tag_post->create();
			
			$this->post_count++;
			$this->update();
			return true;
		}
		return false;
	}
	function unrelate_to_post($post) {
		$tag_post = TagPost::find_by_tag_and_post($this, $post);
		if($tag_post->exists()) {
			$tag_post->delete();

			$this->post_count--;
			$this->update();

			if ($this->post_count < 1) 
				$this->delete();

			return true;
		}
		return false;
	}

	function get_random_tags_by_duration($board, $limit, $duration) {
		$db = get_conn();
		$table = get_table_name('tag');
		$tag_post_table = get_table_name('tag_post');
		return $db->fetchall("SELECT name, COUNT(name) AS count FROM $table AS t INNER JOIN $tag_post_table AS tp ON t.id = tp.tag_id AND t.board_id = ".$board->id." AND tp.created_at > ".(time()-$duration)." GROUP BY name ORDER BY RAND() LIMIT $limit" );
	}
	function get_max_count_by_duration($board, $duration) {
		$db = get_conn();
		$table = get_table_name('tag');
		$tag_post_table = get_table_name('tag_post');
		return $db->fetchone("SELECT MAX(count) AS count FROM (SELECT count(name) as count FROM $table AS t INNER JOIN $tag_post_table AS tp ON t.id = tp.tag_id AND t.board_id = ".$board->id." AND tp.created_at > ".(time()-$duration)." GROUP BY name) AS temp");
	}
}
?>