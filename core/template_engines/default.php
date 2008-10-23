<?php
class DefaultTemplate {
	function DefaultTemplate($path, $view) {
		$this->path = $path;
		$this->view = $view;
		$this->vars = get_global_template_vars();
	}
	function set($key, $value) {
		$this->vars[$key] = $value;
	}
	function render() {
		extract($this->vars);
		include "$this->path/header.php";
		include "$this->path/$this->view.php";
		include "$this->path/footer.php";
	}
	function render_partial() {
		extract($this->vars);
		include "$this->path/$this->view.php";
	}
}
?>
