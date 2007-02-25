<?php
function format_body(&$model) {
	$model->body = format_plain($model->body);
}
add_filter('PostList', 'format_body', 500);
add_filter('PostView', 'format_body', 500);
add_filter('PostViewRSS', 'format_body', 500);
add_filter('PostViewComment', 'format_body', 500);

function sanitize(&$post) {
	$post->name = htmlspecialchars($post->name);
}
add_filter('PostView', 'sanitize', 0);
?>
