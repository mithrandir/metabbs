<?php
function before_say_hello_handler() {
	echo "before";
}
function say_hello_handler() {
	global $filters;
	echo "<h1>Hello, world!</h1>";
	echo "<p>This is MetaBBS Plugin API test.</p>";
	echo "<pre>";
	print_r($filters);
	echo "</pre>";
}
function collision_test_callback() {
	echo '<!-- collision! -->';
}
function say_hello_init() {
	add_handler('say', 'hello', 'before_say_hello_handler', 'before');
	add_handler('say', 'hello', 'say_hello_handler');
	add_filter('collision-test', 'test', 10);
	add_filter('collision-test', 'test_overwrite', 10, META_FILTER_OVERWRITE);
	add_filter('collision-test', 'test_prepend', 10, META_FILTER_PREPEND);
	add_filter('collision-test', 'test_append', 10, META_FILTER_APPEND);
	add_filter('collision-test', 'test_callback', 10, META_FILTER_CALLBACK, 'collision_test_callback');
}
function say_hello_install() {
	echo 'installation callback test<br />';
	echo link_to('Continue...', 'admin', 'plugins');
	exit;
}
function say_hello_uninstall() {
	echo 'uninstallation callback test<br />';
	echo link_to('Continue...', 'admin', 'plugins');
	exit;
}

register_plugin('SayHello', 'MetaBBS plugin example. <strong>for testing purpose only!</strong>', 'say_hello_init', 'say_hello_install', 'say_hello_uninstall');
?>
