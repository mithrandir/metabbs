<?php
class FeedUser extends Model {
	var $model = 'feed_user';
	// class method
	function find($id) {
		return find('feed_user', $id);
	}
	function find_all_by_user($user) {
		$db = get_conn();
		$table = get_table_name('feed_user');
		return $db->fetchall("SELECT * FROM $table WHERE user_id = ?", 'FeedUser', array($user->id));
	}
	function find_all_by_feed($feed) {
		$db = get_conn();
		$table = get_table_name('feed_user');
		return $db->fetchall("SELECT * FROM $table WHERE feed_id = ?", 'FeedUser', array($feed->id));
	}
	function find_by_user_and_feed($user, $feed) {
		$db = get_conn();
		$table = get_table_name('feed_user');
		return $db->fetchrow("SELECT * FROM $table WHERE feed_id = ? AND user_id = ? LIMIT 1", 'FeedUser', array($feed->id, $user->id));
	}
	function get_feed() {
		return Feed::find($this->feed_id);
	}
	function delete_by_user($user) {
		$feed_users = FeedUser::find_all_by_user($user);
		foreach($feed_users as $feed_user) 
			$feed_user->delete();
	}

	function create() {
		$this->created_at = time();
		Model::create();
	}
}
?>