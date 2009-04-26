<?php
class FeedBoard extends Model {
	var $model = 'feed_board';
	var $board_id;
	var $feed_id;
	// class method

	function _init() {
		$this->table = get_table_name('feed_board');
	}
	function find($id) {
		return find('feed_board', $id);
	}
	function find_by_feed_and_board($feed, $board) {
		$db = get_conn();
		$table = get_table_name('feed_board');
		return $db->fetchrow("SELECT * FROM $table WHERE feed_id = ".$feed->id." and board_id = ".$board->id, 'FeedBoard');
	}	
	function find_by_feed_id_and_board_id($feed_id, $board_id) {
		$db = get_conn();
		$table = get_table_name('feed_board');
		return $db->fetchrow("SELECT * FROM $table WHERE feed_id = ".$feed_id." and board_id = ".$board_id, 'FeedBoard');
	}
	function find_all() {
		$db = get_conn();
		$table = get_table_name('feed_board');
		return $db->fetchall("SELECT * FROM $table ", 'FeedBoard');
	}
	function find_all_by_feed($feed) {
		$db = get_conn();
		$table = get_table_name('feed_board');
		return $db->fetchall("SELECT * FROM $table WHERE feed_id = ".$feed->id, 'FeedBoard');
	}
	function get_board() {
		return find('board', $this->board_id);
	}
	function get_feed() {
		return find('feed', $this->feed_id);
	}
}
?>