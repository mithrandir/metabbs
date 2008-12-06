<?php
class StandardTemplate {
	function StandardTemplate($path, $view) {
		$this->path = $path;
		$this->view = $view;
		$this->vars = get_global_template_vars();
		//include 'core/template_engines/standard/filters.php';
	}
	function set($key, $value) {
		$this->vars[$key] = $value;
	}
	function render() {
		extract($this->vars);
		include "core/template_engines/standard/vars.php";
		include "$this->path/header.php";
		include "$this->path/$this->view.php";
		include "$this->path/footer.php";
		include "core/template_engines/standard/footer.php";
	}
	function render_partial() {
		extract($this->vars);
		include "core/template_engines/standard/vars.php";
		include "$this->path/$this->view.php";
	}
}
?>
