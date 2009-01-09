<?php
class Plugin extends Model {
	var $model = 'plugin';

	var $name;
	var $enabled = false;
	var $description = '';
	var $plugin_name;
	//var $installed_version = 0;
	var $version = 0;

	function _init() {
		$this->table = get_table_name('plugin');
	}
	function find_by_name($name) {
		$table = get_table_name('plugin');
		$db = get_conn();
		$plugin = $db->fetchrow("SELECT * FROM $table WHERE name=?", $name, array($name));
		if (!$plugin) {
			$plugin = new $name;
		}
		$plugin->name = $name;
		return $plugin;
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
	function get_plugin_name() {
		return $this->plugin_name ? $this->plugin_name : $this->get_id();
	}
	function update_to($version) {
		update_all('plugin', array('installed_version' => $version), 'id='.$this->id);
		$this->installed_version = $version;
	}
	/* callback methods */
	function on_init() { }
	function on_install() { }
	function on_uninstall() { }
	function on_update() {
		$this->update_to($this->version);
	}
}
function get_enabled_plugins() {
	$db = get_conn();
	$table = get_table_name('plugin');
	return $db->fetchall("SELECT name FROM $table WHERE enabled=1");
}
?>
