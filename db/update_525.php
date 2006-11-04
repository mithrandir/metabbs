<?php
$conn->add_field('comment', 'board_id', 'integer');
$conn->add_index('comment', 'board_id');

$comment_table = get_table_name('comment');
$post_table = get_table_name('post');
$comments = $conn->fetchall("SELECT c.id, p.board_id FROM $post_table as p, $comment_table as c WHERE c.post_id=p.id", "Comment");
foreach ($comments as $comment) {
	$conn->query("UPDATE $comment_table SET board_id=$comment->board_id WHERE id=$comment->id");
}

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
