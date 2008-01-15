<?php
require_once "../lib/request.php";
require_once "../lib/response.php";
require_once "../lib/controller.php";

class TestController extends Controller {
	var $ran = FALSE;

	function action_test() {
		$this->ran = TRUE;
	}
}

class ControllerTest extends UnitTestCase {
	function testProcess() {
		$request = new AbstractRequest;
		$response = new Response;
		$request->action = 'test';
		$c = new TestController;
		$this->assertTrue($c->process($request, $response));
		$this->assertTrue($c->ran);
	}
}
