<?php
// attachment_count process
$conn->add_field('post', 'attachment_count', 'integer');
$attachment_result = $conn->query("SELECT DISTINCT post_id, COUNT(post_id) AS attachment_count FROM  " . get_table_name('attachment') . " GROUP BY post_id");
while ($attachment = $attachment_result->fetch())
	$conn->query("UPDATE " . get_table_name('post') . " SET attachment_count = {$attachment['attachment_count']} WHERE id = {$attachment['post_id']}");
?>