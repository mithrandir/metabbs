<?php
class Controller {
	function Controller() {
		$this->view_path = "app/views/".$this->get_name();
	}

	/*static*/ function construct($name) {
		$class = $name.'Controller';
		return new $class;
	}

	function get_name() {
		return strtolower(substr(get_class($this), 0, -10));
	}

	function set_up() {
	}

	function process($request, $response) {
		$this->request = $request;
		$this->response = $response;

		$this->set_up();
		call_user_func(array(&$this, 'action_' . $request->action));
		$this->render($request->action);

		return TRUE;
	}

	function render($view) {
		ob_start();
		include "$this->view_path/$view.php";
		$this->response->body = ob_get_contents();
		ob_end_clean();
	}
}
