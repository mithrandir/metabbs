<?php
class Metadata {
	function Metadata(&$model) {
		$this->model = &$model;
		$this->db = get_conn();
		$this->table = get_table_name('metadata');
		$this->attributes = array();
		$this->loaded = false;
	}
	function load() {
		if ($this->loaded || !$this->model->exists()) return;
		$result = $this->db->query("SELECT * FROM $this->table WHERE model_id={$this->model->id} AND model='{$this->model->model}'");
		while ($data = $result->fetch()) {
			$this->attributes[$data['key']] = $data['value'];
		}
		$this->loaded = true;
	}
	function reload() {
		$this->loaded = false;
		$this->attributes = array();
		$this->load();
	}
	function get($key) {
		if (!$this->loaded) $this->load();
		return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : '';
	}
	function set($key, $value) {
		if ($this->model->exists()) {
			if (!$this->loaded) $this->load();
			if (!array_key_exists($key, $this->attributes)) {
				insert('metadata', array('model' => $this->model->model, 'model_id' => $this->model->id, 'key' => $key, 'value' => $value));
			} else {
				update_all('metadata', array('value' => $value), "model='{$this->model->model}' AND model_id={$this->model->id} AND `key`=".$this->db->quote($key));
			}
		}

		$this->attributes[$key] = $value;
	}
	function remove($key) {
		if (!$this->loaded) $this->load();
		delete_all('metadata', "model='{$this->model->model}' AND model_id={$this->model->id} AND `key`=".$this->db->quote($key));
		$this->reload();
	}
	function reset() {
		delete_all('metadata', "model='{$this->model->model}' AND model_id={$this->model->id}");
	}
}
?>
