<?php
$description = "adding comment count cache field";

$conn->add_field('post', 'comment_count', 'integer');

$comment_table = get_table_name('comment');
$post_table = get_table_name('post');
$conn->query("UPDATE $post_table SET last_update_at=created_at");
$result = $conn->get_result("SELECT p.id, COUNT(c.id) AS count FROM $post_table p, $comment_table c WHERE p.id=c.post_id AND c.user_id != -1 GROUP BY c.post_id");
while ($row = $result->fetch()) {
	$conn->query("UPDATE $post_table SET comment_count=$row[count] WHERE id=$row[id]");
}
?>
