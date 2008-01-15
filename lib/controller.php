<?php
class Controller {
	function process($request, $response) {
		$this->request = $request;
		$this->response = $response;

		call_user_func(array(&$this, 'action_' . $request->action));

		return TRUE;
	}
}
