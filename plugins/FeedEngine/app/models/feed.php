<?php
class Feed extends Model {
	var $model = 'feed';
	var $url;
	var $link;
	var $title;
	var $description;
	var $owner_id;
	
	function _init() {
		$this->table = get_table_name('feed');
		$this->board_table = get_table_name('board');
		$this->user_table = get_table_name('user');
		$this->category_table = get_table_name('category');
		$this->attachment_table = get_table_name('attachment');
		$this->tag_table = get_table_name('tag');
		$this->tag_post_table = get_table_name('tag_post');
		$this->feed_user_table = get_table_name('feed_user');
		$this->post_table = get_table_name('post');
		$this->feed_post_table = get_table_name('feed_post');
		$this->group_post_table = get_table_name('group_post');
	}

	// class method
	function find($id) {
		return find('feed', $id);
	}
	function find_all($offset = 0, $limit = null, $order_by = 'id DESC') {
		$db = get_conn();
		$table = get_table_name('feed');
		return $db->fetchall("SELECT * FROM $table".($order_by ? " ORDER BY $order_by":'').($limit ? " LIMIT".($offset != 0 ? " $offset, ":'').' '.$limit : ''), 'Feed');
	}
	function find_all_having_owner($offset = 0, $limit = null, $order_by = 'id DESC') {
		$db = get_conn();
		$table = get_table_name('feed');
		return $db->fetchall("SELECT * FROM $table WHERE owner_id > 0".($order_by ? " ORDER BY $order_by":'').($limit ? " LIMIT".($offset != 0 ? " $offset, ":'').' '.$limit : ''), 'Feed');
	}
	function find_all_by_board($board, $offset = 0, $limit = null, $order_by = 'id DESC') {
		$db = get_conn();
		$table = get_table_name('feed');
		$feed_board_table = get_table_name('feed_board');
		return $db->fetchall("SELECT f.* FROM $table AS f INNER JOIN $feed_board_table AS fb ON f.id = fb.feed_id AND fb.board_id = $board->id" . ($order_by ? " ORDER BY f.$order_by":'') . ($limit ? " LIMIT" . ($offset != 0 ? " $offset, ":'') . ' ' . $limit : ''), 'Feed');
	}
	function find_all_by_board_having_owner($board, $offset = 0, $limit = null, $order_by = 'id DESC') {
		$db = get_conn();
		$table = get_table_name('feed');
		$feed_board_table = get_table_name('feed_board');
		return $db->fetchall("SELECT f.* FROM $table AS f INNER JOIN $feed_board_table AS fb ON f.id = fb.feed_id AND fb.board_id = $board->id WHERE f.owner_id > 0" . ($order_by ? " ORDER BY f.$order_by":'') . ($limit ? " LIMIT" . ($offset != 0 ? " $offset, ":'') . ' ' . $limit : ''), 'Feed');
	}
	function find_one_in_random($duration) {
		$db = get_conn();
		$table = get_table_name('feed');
		return $db->fetchrow("SELECT * FROM $table WHERE updated_at <".(time() - $duration)." AND active > 0 ORDER BY updated_at ASC LIMIT 1", 'Feed');
	}
	function find_one_having_owner_in_random($duration) {
		$db = get_conn();
		$table = get_table_name('feed');
		return $db->fetchrow("SELECT * FROM $table WHERE owner_id > 0 AND updated_at <".(time() - $duration)." AND active > 0 ORDER BY updated_at ASC LIMIT 1", 'Feed');
	}
	function find_one_by_board_in_random($board, $duration) {
		$db = get_conn();
		$table = get_table_name('feed');
		$feed_board_table = get_table_name('feed_board');
		return $db->fetchrow("SELECT f.* FROM $table AS f INNER JOIN $feed_board_table AS fb ON f.id = fb.feed_id AND fb.board_id = $board->id WHERE f.updated_at <".(time() - $duration)." AND f.active > 0 ORDER BY f.updated_at ASC LIMIT 1", 'Feed');
	}
	function find_one_by_board_having_owner_in_random($board, $duration) {
		$db = get_conn();
		$table = get_table_name('feed');
		$feed_board_table = get_table_name('feed_board');
		return $db->fetchrow("SELECT f.* FROM $table AS f INNER JOIN $feed_board_table AS fb ON f.id = fb.feed_id AND fb.board_id = $board->id WHERE f.owner_id > 0 AND f.updated_at <".(time() - $duration)." AND f.active > 0 ORDER BY f.updated_at ASC LIMIT 1", 'Feed');
	}








/*	function find_all_in_activity() {
		$db = get_conn();
		$table = get_table_name('feed');
		return $db->fetchall("SELECT * FROM $table WHERE owner_id >= 0", 'Feed');
	}
	function find_all_by_feed_board_in_activity($board) {
		$db = get_conn();
		$table = get_table_name('feed');
		$feed_board = get_table_name('feed_board');
		return $db->fetchall("SELECT f.* FROM $table AS f INNER JOIN $feed_board AS fb ON f.id = fb.feed_id AND fb.board_id = {$board->id} WHERE f.owner_id >= 0", 'Feed');
	}


	function find_all_by_feed_board_having_owner($board) {
		$db = get_conn();
		$table = get_table_name('feed');
		$feed_board = get_table_name('feed_board');
		return $db->fetchall("SELECT  f.* FROM $table AS f INNER JOIN $feed_board AS fb ON f.id = fb.feed_id AND fb.board_id = {$board->id} WHERE f.owner_id >= 0".($order_by ? " ORDER BY f.$order_by":'').($limit ? " LIMIT".($offset != 0 ? " $offset, ":'').' '.$limit : ''), 'Feed');
	}*/
	function find_all_by_user($user) {
		$db = get_conn();
		$table = get_table_name('feed');
		$feed_user_table = get_table_name('feed_user');
		return $db->fetchall("SELECT f.* FROM $table AS f INNER JOIN $feed_user_table AS fu ON f.id = fu.feed_id AND fu.user_id = $user->id", 'Feed');
	}

	function find_all_by_owner($owner) {
		$db = get_conn();
		$table = get_table_name('feed');
		return $db->fetchall("SELECT * FROM $table WHERE owner_id = ".$owner->id, 'Feed');
	}
	function find_first_by_user($user) {
		$db = get_conn();
		$table = get_table_name('feed');
		$feed_user_table = get_table_name('feed_user');
		return $db->fetchRow("SELECT f.* FROM $table AS f INNER JOIN $feed_user_table AS fu ON f.id = fu.feed_id AND fu.user_id = $user->id LIMIT 1", 'Feed');
	}
	function find_by_url($url) {
		return find_by('feed', 'url', $url);
	}
	function search($key, $value) {
		$db = get_conn();
		$table = get_table_name('feed');
		return $db->fetchall("SELECT * FROM $table WHERE ! LIKE '%!%'", 'Feed', array($key, $value));
	}
	function get_post_by_link($link, $board) {
		$db = get_conn();
		$table = get_table_name('post');
		return $db->fetchRow("SELECT * FROM $table WHERE board_id = ? AND feed_link= ?", 'Post', array($board->id, $link));
	}
	function get_all_post_count($board) {
		$db = get_conn();
		$table = get_table_name('post');
		return $db->fetchone("SELECT count(*) FROM $table WHERE board_id = $board->id AND feed_id != 0");
	}

	function create() {
		$this->updated_at = $this->created_at = time();
		Model::create();
	}
	function update() {
		$this->updated_at = time();
		Model::update();
	}
	function delete() {
		$this->db->execute("DELETE FROM $this->feed_user_table WHERE feed_id=$this->id");
		$users = $this->get_users();
		foreach ($users as $user)
			Feed::reset_position_by_user($user);

		$posts = $this->get_posts();
		foreach ($posts as $post)
			$post->delete();
		delete_all('post', "feed_id = $this->id");
		Model::delete();
	}
	function count() {
		$db = get_conn();
		$table = get_table_name('feed');
		return $db->fetchone("SELECT COUNT(*) FROM $table");
	}
	function count_having_owner() {
		$db = get_conn();
		$table = get_table_name('feed');
		return $db->fetchone("SELECT COUNT(*) FROM $table WHERE owner_id >= 0 ");
	}
	function get_users() {
		return $this->db->fetchall("SELECT u.* FROM $this->user_table AS u INNER JOIN $this->feed_user_table AS fu ON fu.user_id = u.id WHERE feed_id = ?", 'User', array($this->id));
	}
	function get_first_user() {
		$users = $this->get_users();
		if (empty($users)) return false;
		return $users[0];
	}
	function get_posts() {
		return $this->db->fetchall("SELECT * FROM $this->post_table WHERE feed_id = ?", 'Post', array($this->id));
	}
	function get_owner() {
		$owner = User::find($this->owner_id);
		return $owner->exists() ? $owner : false;
	}
	function reset_position_by_user($user) {
		$db = get_conn();
		$table = get_table_name('feed_user');
		$feed_users = $db->fetchall("SELECT * FROM $table WHERE user_id=? ORDER BY position ASC", 'User', array($user->id));
		$position = 1;
		foreach($feed_users AS $feed_user) {
			$db->execute("UPDATE $table SET position=$position WHERE id={$feed_user->id}");
			$position++;
		}
	}
	function hide_posts() {
		// query
		$posts = $this->get_posts();
		foreach ($posts as $post) {
			$post->secret = 1;
			$post->update();
		}
	}
	function show_posts() {
		// query
		$posts = $this->get_posts();
		foreach ($posts as $post) {
			$post->secret = 0;
			$post->update();
		}
	}
	function is_owner($user) {
		return $this->owner_id == $user->id;
	}
	function have_owner() {
		return $this->owner_id > 0;
	}
	function is_active() {
		return $this->active;
//		return $this->owner_id >= 0;
	}
	function is_related($user) {
		$feed_post = FeedUser::find_by_user_and_feed($this, $user);
		return $feed_post->exists();
	}
	function get_user_count() {
		return $this->db->fetchone("SELECT count(*) FROM $this->feed_user_table WHERE feed_id = $this->id");
	}
	function get_post_count() {
		return $this->db->fetchone("SELECT count(*) FROM $this->post_table WHERE feed_id = $this->id");
	}
	function relate_to_user($user) {
		$feed_user = FeedUser::find_by_user_and_feed($user, $this);
		if(!$feed_user->exists()) {
			unset($feed_user);
			$feed_user = new FeedUser();
			$feed_user->user_id = $user->id; 
			$feed_user->feed_id = $this->id;
			$feed_user->position = $this->db->fetchone("SELECT MAX(position) FROM {$this->feed_user_table} WHERE user_id = $user->id") + 1;
			$feed_user->create();

			return true;
		}
		return false;
	}
	function unrelate_to_user($user) {
		$feed_user = FeedUser::find_by_user_and_feed($user, $this);
		if($feed_user->exists()) {
			$feed_user->delete();
			Feed::reset_position_by_user($user);

			return true;
		}
		return false;
	}
	function is_first($user) {
		$higher = $this->db->fetchrow("SELECT id, position FROM $this->feed_user_table WHERE user_id = {$user->id} AND position <> 0 AND position < {$this->position} ORDER BY position DESC LIMIT 1");
		return !$higher->exists();
	}
	function is_last($user) {
		$lower = $this->db->fetchrow("SELECT id, position FROM $this->feed_user_table WHERE user_id = {$user->id} AND position <> 0 AND position > {$this->position} ORDER BY position ASC LIMIT 1");
		return !$lower->exists();
	}
	function move_lower($user) {
		$lower = $this->db->fetchrow("SELECT id, position FROM $this->feed_user_table WHERE user_id = {$user->id} AND position <> 0 AND position > {$this->position} ORDER BY position ASC LIMIT 1");
		if(!$lower->exists()) return false;
		$this->db->execute("UPDATE $this->feed_user_table SET position={$this->position} WHERE id={$lower->id}");
		$this->db->execute("UPDATE $this->feed_user_table SET position={$lower->position} WHERE id={$this->id}");
		return true;
	}
	function move_higher($user) {
		$higher = $this->db->fetchrow("SELECT id, position FROM $this->feed_user_table WHERE user_id = {$user->id} AND position <> 0 AND position < {$this->position} ORDER BY position DESC LIMIT 1");
		if(!$higher->exists()) return false;
		$this->db->execute("UPDATE $this->feed_user_table SET position={$this->position} WHERE id={$higher->id}");
		$this->db->execute("UPDATE $this->feed_user_table SET position={$higher->position} WHERE id={$this->id}");
		return true;
	}
}

//foreach(Feed::find_all() as $feed) {
//	$feed->url = trim($feed->url);
//	$feed->update();
//}
?>