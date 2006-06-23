<?php
function model($name) {
	global $model_dir;
	require_once "$model_dir/$name.php";
}

class Model
{
	var $id;

	function Model($attributes = null) {
		$this->import($attributes);
	}
	function get_model_name() {
		if (!isset($this->model)) {
			$this->model = strtolower(get_class($this));
		}
		return $this->model;
	}
	function import($attributes) {
		if (is_array($attributes)) {
			foreach ($attributes as $key => $value) {
				$this->$key = $value;
			}
		}
	}
	function exists() {
		return $this->id;
	}
	function get_id() {
		return $this->id;
	}
}

?>
