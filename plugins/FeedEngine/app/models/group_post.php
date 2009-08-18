<?php
class GroupPost extends Model {
	var $model = 'group_post';

	// class methods
	function find($id) {
		return find('group_post', $id);
	}
	function find_all_by_post($post) {
		$db = get_conn();
		$table = get_table_name('group_post');
		return $db->fetchall("SELECT * FROM $table WHERE post_id = ?", 'GroupPost', array($post->id));
	}
	function find_all_by_group($group) {
		$db = get_conn();
		$table = get_table_name('group_post');
		return $db->fetchall("SELECT * FROM $table WHERE group_id = ?", 'GroupPost', array($group->id));
	}
	function find_by_group_and_post($group, $post) {
		$db = get_conn();
		$table = get_table_name('group_post');
		return $db->fetchrow("SELECT * FROM $table WHERE group_id = ? AND post_id = ? LIMIT 1", 'GroupPost', array($group->id, $post->id));
	}
	function delete_by_post($post) {
		$group_posts = GroupPost::find_all_by_post($post);
		foreach($group_posts as $group_post) 
			$group_post->delete();
	}
	function delete_by_groups($group) {
		$group_posts = GroupPost::find_all_by_group($group);
		foreach($group_posts as $group_post) 
			$group_post->delete();
	}

	function get_group() {
		return Group::find($this->group_id);
	}
	function create() {
		$this->created_at = time();
		Model::create();
	}
}
?>