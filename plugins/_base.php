<?php
function format_body(&$model) {
	$model->body = nl2br(autolink(htmlspecialchars($model->body)));
}
add_filter('PostView', 'format_body', 500);
add_filter('PostViewComment', 'format_body', 500);
?>
