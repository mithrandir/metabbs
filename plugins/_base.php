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
	$model->name_orig = $model->name;
	if ($user->level > 0) {
		$model->name = "<a href=\"".url_for($user)."\" class=\"dialog\">$model->name</a>";
	}
}
add_filter('PostList', 'link_user', 600);
add_filter('PostView', 'link_user', 600);
add_filter('PostViewComment', 'link_user', 600);

function sanitize(&$model) {
	$model->name = htmlspecialchars($model->name);
}
add_filter('PostList', 'sanitize', 0);
add_filter('PostView', 'sanitize', 0);
add_filter('PostViewComment', 'sanitize', 0);
add_filter('UserInfo', 'sanitize', 0);

include dirname(__FILE__).'/../lib/template_engines/standard/filters.php';
?>
