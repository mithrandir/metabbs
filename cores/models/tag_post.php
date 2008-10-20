<?php
class TagPost extends Model {
	var $model = 'tag_post';

	// class methods
	function find($id) {
		return find('tag_post', $id);
	}
	function find_all_by_post($post) {
		$db = get_conn();
		$table = get_table_name('tag_post');
		return $db->fetchall("SELECT * FROM $table WHERE post_id = ?", 'TagPost', array($post->id));
	}
	function find_by_tag_and_post($tag, $post) {
		$db = get_conn();
		$table = get_table_name('tag_post');
		return $db->fetchrow("SELECT * FROM $table WHERE tag_id = ? AND post_id = ? LIMIT 1", 'TagPost', array($tag->id, $post->id));
	}
	function get_tag() {
		return Tag::find($this->tag_id);
	}
	function delete_by_post($post) {
		$tag_posts = TagPost::find_all_by_post($post);
		foreach($tag_posts as $tag_post) 
			$tag_post->delete();
	}

	function create() {
		$this->created_at = time();
		Model::create();
	}
}
?>
