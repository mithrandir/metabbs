<?php
function name_cookie_handler() {
	$GLOBALS['name'] = cookie_get('name');
}
function name_cookie_filter($model) {
	cookie_register('name', $model->name);
}

add_handler('board', 'post', 'name_cookie_handler', 'before');
add_handler('post', 'edit', 'name_cookie_handler', 'before');
add_handler('post', 'index', 'name_cookie_handler', 'before');

add_filter('PostSave', 'name_cookie_filter', 20);
add_filter('PostComment', 'name_cookie_filter', 20);
?>
