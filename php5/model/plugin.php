<?php
class Plugin extends Model {
	var $model = 'plugin';

	var $name;
	var $enabled = false;
	var $description = '';
	var $plugin_name;

	function _init() {
		$this->table = get_table_name('plugin');
		$this->name = $this->get_id();
	}
	function find_by_name($name) {
		$table = get_table_name('plugin');
		$db = get_conn();
		$plugin = $db->fetchrow("SELECT * FROM $table WHERE name=?", $name, array($name));
		if ($plugin) return $plugin;
		else return new $name();
	}
	function get_id() {
		return get_class($this);
	}
	function enable() {
		$this->enabled = 1;
		$this->update();
	}
	function disable() {
		$this->enabled = 0;
		$this->update();
	}
	function get_plugin_name() {
		return $this->plugin_name ? $this->plugin_name : $this->get_id();
	}
	/* callback methods */
	function on_init() { }
	function on_install() { }
	function on_uninstall() { }
}
function get_plugins() {
	$dp = opendir(METABBS_DIR . '/plugins');
	$plugins = array();
	while ($file = readdir($dp)) {
		@list($name, $ext) = explode('.', $file);
		if ($ext == 'php') {
			include_once(METABBS_DIR . '/plugins/' . $file);
		}
	}
	closedir($dp);
	return $GLOBALS['__plugins'];
}
function get_enabled_plugins() {
	$db = get_conn();
	$table = get_table_name('plugin');
	return $db->fetchall("SELECT * FROM $table WHERE enabled=1");
}
?>
