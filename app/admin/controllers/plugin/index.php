<?php
$plugins = get_plugins();
function compare_plugin_names($a, $b) {
	return strcmp($a->get_plugin_name(), $b->get_plugin_name());
}
usort($plugins, 'compare_plugin_names');
?>
