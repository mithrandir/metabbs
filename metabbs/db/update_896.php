<?php
$description = "adding support for custom sorting mode";

$conn->add_field('board', 'order_by', 'string', 20);
$conn->add_field('post', 'last_update_at', 'timestamp');

$comment_table = get_table_name('comment');
$post_table = get_table_name('post');
$conn->query("UPDATE $post_table SET last_update_at=created_at");
$result = $conn->get_result("SELECT post_id, MAX(created_at) AS last_comment_at FROM $comment_table GROUP BY post_id");
while ($row = $result->fetch()) {
	$conn->query("UPDATE $post_table SET last_update_at=$row[last_comment_at] WHERE id=$row[post_id]");
}
?>
