<?php
function before_say_hello_handler() {
	echo "before";
}
function say_hello_handler() {
	echo "<h1>Hello, world!</h1>";
	echo "<p>This is MetaBBS Plugin API test.</p>";
}
add_handler('say', 'hello', 'before_say_hello_handler', 'before');
add_handler('say', 'hello', 'say_hello_handler');

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
