<?php
function before_say_hello_handler() {
	echo "before";
}
function say_hello_handler() {
	echo "<h1>Hello, world!</h1>";
	echo "<p>This is MetaBBS Plugin API test.</p>";
}
function say_hello_init() {
	add_handler('say', 'hello', 'before_say_hello_handler', 'before');
	add_handler('say', 'hello', 'say_hello_handler');
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

register_plugin('SayHello', 'MetaBBS plugin example', 'say_hello_init', 'say_hello_install', 'say_hello_uninstall');
?>
