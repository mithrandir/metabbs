<?php
require_once "../lib/request.php";
require_once "../lib/response.php";
require_once "../lib/controller.php";

class TestController extends Controller {
	var $ran = FALSE;
	var $setup = FALSE;

	function set_up() {
		$this->setup = TRUE;
	}

	function action_test() {
		$this->ran = $this->setup;
		$this->var = 'test';
	}
}

class ControllerTest extends UnitTestCase {
	function setUp() {
		$this->c = new TestController;
		$this->c->view_path = 'fixtures';
	}

	function testProcess() {
		$request = new AbstractRequest;
		$response = new AbstractResponse;
		$request->action = 'test';
		$this->assertTrue($this->c->process($request, $response));
		$this->assertTrue($this->c->setup);
		$this->assertTrue($this->c->ran);
	}

	function testGetName() {
		$this->assertEqual('test', $this->c->get_name());
	}

	function testRender() {
		$this->c->response = new AbstractResponse;
		$this->c->var = 'Hello, world!';
		$this->c->render('test');
		$this->assertEqual('Hello, world!', $this->c->response->body);
	}
	
	function testConstruct() {
		$this->assertIsA(Controller::construct('test'), 'TestController');
	}
}
