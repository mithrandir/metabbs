<?php
$filters = array();
$handlers = array();
$__plugins = array();

function register_plugin($name, $description, $init_function, $install_function = '', $uninstall_function = '') {
	global $__plugins;
	$plugin = Plugin::find_by_name($name);
	$plugin->name = $name;
	$plugin->description = $description;
	$plugin->init_function = $init_function;
	$plugin->install_function = $install_function;
	$plugin->uninstall_function = $uninstall_function;
	if ($plugin->enabled) {
		$func = $plugin->init_function;
		$func();
	}
	$__plugins[$name] = $plugin;
	ksort($__plugins);
}

// Filter API
// TODO: 같은 우선순위에 여러 개 필터가 등록되었을 때
define('META_FILTER_OVERWRITE', 1);
define('META_FILTER_PREPEND', 2);
define('META_FILTER_APPEND', 3);
define('META_FILTER_CALLBACK', 4);
function add_filter($event, $callback, $priority, $collision = META_FILTER_OVERWRITE, $callback = null) {
	global $filters;
	if (@array_key_exists($priority, $filters[$event])) {
		switch ($collision) {
			case META_FILTER_OVERWRITE:
				$filters[$event][$priority] = $callback;
			break;
			case META_FILTER_PREPEND:
				$priority--;
				add_filter($event, $callback, $priority, $collision);
			break;
			case META_FILTER_APPEND:
				$priority++;
				add_filter($event, $callback, $priority, $collision);
			break;
			case META_FILTER_CALLBACK:
				if ($callback) $callback();
			break;
		}
	} else {
		$filters[$event][$priority] = $callback;
	}
}
function remove_filter($event, $callback) {
	global $filters;
	$key = array_search($callback, $filters[$event]);
	unset($filters[$event][$key]);
}
function apply_filters($event, &$model) {
	global $filters;
	if (isset($filters[$event])) {
		ksort($filters[$event]);
		foreach ($filters[$event] as $callback) {
			call_user_func_array($callback, array(&$model));
		}
	}
}
function apply_filters_array($event, &$array) {
	foreach (array_keys($array) as $key) {
		apply_filters($event, $array[$key]);
	}
}

// Handler API
// TODO: 한 액션을 여러 핸들러가 처리해야 할 때 
function add_handler($controller, $action, $callback, $type = 'hook') {
	global $filters;
	$filters[$controller][$action][$type] = $callback;
}
function run_hook_handler($controller, $action) {
	global $filters;
	run_before_handler($controller, $action);
	if (isset($filters[$controller][$action]['hook'])) {
		call_user_func($filters[$controller][$action]['hook']);
		return true;
	} else {
		return false;
	}
}
function run_before_handler($controller, $action) {
	global $filters;
	if (isset($filters[$controller][$action]['before'])) {
		call_user_func($filters[$controller][$action]['before']);
	}
}

foreach (get_enabled_plugins() as $plugin) {
	include_once("plugins/$plugin->name.php");
}
?>
