<?php
class Plugin extends Model {
	var $model = 'plugin';

	var $name;
	var $enabled = false;
	var $description = '';

	function _init() {
		$this->table = get_table_name('plugin');
	}
	function find_by_name($name) {
		$table = get_table_name('plugin');
		$db = get_conn();
		return $db->fetchrow("SELECT * FROM $table WHERE name=?", 'Plugin', array($name));
	}
	function get_id() {
		return $this->name;
	}
	function enable() {
		$this->enabled = 1;
		$this->update();
	}
	function disable() {
		$this->enabled = 0;
		$this->update();
	}
}
function get_plugins() {
	$dp = opendir(METABBS_DIR . '/plugins');
	$plugins = array();
	while ($file = readdir($dp)) {
		list($name, $ext) = explode('.', $file);
		if ($ext == 'php') {
			$plugin = Plugin::find_by_name($name);
			$plugin->name = $name;
			$plugins[] = $plugin;
		}
	}
	closedir($dp);
	return $plugins;
}
function get_enabled_plugins() {
	$db = get_conn();
	$table = get_table_name('plugin');
	return $db->fetchall("SELECT * FROM $table WHERE enabled=1");
}
?>
