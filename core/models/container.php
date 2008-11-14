<?php
class Container {
	var $type = 'board'; // XXX

	function find_by_name($name) {
		return find_by('container', 'name', $name);
	}

	function get_controller() {
		require_once "containers/$this->type/container.php";

		$class = $this->type . 'Controller';
		return new $class($this);
	}
}
