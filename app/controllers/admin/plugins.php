<?php
$plugins = get_plugins();

function compare_plugin_names($a, $b) {
	if ($a->plugin_name == $b->plugin_name)
		return 0;
	return ($a->plugin_name < $b->plugin_name) ? -1 : 1;
}
usort($plugins, 'compare_plugin_names');
?>
