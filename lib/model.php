<?php
function model($name) {
	global $lib_dir;
	require_once "$lib_dir/$name.php";
}

class Model
{
	var $id;

	function Model($attributes = array()) {
		$this->import($attributes);
	}
	function get_model_name() {
		if (!isset($this->model)) {
			$this->model = strtolower(get_class($this));
		}
		return $this->model;
	}
	function import($attributes) {
		if (!is_array($attributes)) {
			return;
		}
		foreach ($attributes as $key => $value) {
			$this->$key = $value;
		}
	}
	function exists() {
		return $this->id;
	}
	function save() {
		return (!$this->exists()) ? $this->create() : $this->update();
	}
	function create() { }
	function update() { }
	function get_body() {
		return format($this->body);
	}
	function get_id_for_href() {
		return $this->id;
	}
	function get_href() {
		return $this->get_model_name() . '/' . $this->get_id_for_href();
	}
	function validate() {
		return true;
	}
}

?>
