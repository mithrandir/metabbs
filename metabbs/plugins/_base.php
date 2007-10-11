<?php
function format_body(&$model) {
	$model->body = format_plain($model->body);
}
add_filter('PostList', 'format_body', 500);
add_filter('PostView', 'format_body', 500);
add_filter('PostViewRSS', 'format_body', 500);
add_filter('PostViewComment', 'format_body', 500);

function link_user(&$model) {
	$user = $model->get_user();
	if ($user->level > 0) {
		$model->name = link_to_user($user);
	}
}
add_filter('PostList', 'link_user', 600);
add_filter('PostView', 'link_user', 600);
add_filter('PostViewComment', 'link_user', 600);

function sanitize(&$post) {
	$post->name = htmlspecialchars($post->name);
}
add_filter('PostList', 'sanitize', 0);
add_filter('PostView', 'sanitize', 0);
?>
