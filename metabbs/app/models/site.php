<?php
class Site {
	/*static*/ function get_latest_posts($count) {
		$db = get_conn();
		$post_table = get_table_name('post');
		$board_table = get_table_name('board');
		return $db->fetchall("SELECT p.* FROM $post_table as p, $board_table as b WHERE b.id=p.board_id AND b.perm_read = 0 ORDER BY p.id DESC LIMIT $count", 'Post');
	}

	/*static*/ function get_latest_comments($count) {
		$db = get_conn();
		$comment_table = get_table_name('comment');
		$board_table = get_table_name('board');
		$post_table = get_table_name('post');
		return $db->fetchall("SELECT c.* FROM $comment_table as c, $board_table as b, $post_table as p WHERE b.id=p.board_id AND p.id=c.post_id AND p.secret = 0 AND b.perm_read = 0 ORDER BY c.id DESC LIMIT $count", 'Comment');
	}
}
