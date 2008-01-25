<?php
require_once "../lib/controller.php";
require_once "../lib/request.php";
require_once "../lib/response.php";
require_once "../app/controllers/board.php";

class BoardControllerTest extends UnitTestCase {
	function setUp() {
		$this->c = new BoardController;
		$this->c->view_path = "../" . $this->c->view_path;
		$this->req = new AbstractRequest;
		$this->res = new AbstractResponse;
	}

	function testList() {
		$this->request('GET', 'index', array('id' => 'test'));
		$this->assertEqual(1, $this->c->board->id);
		$this->assertEqual(1, $this->c->page);
	}

	function request($method, $action, $params = array()) {
		$this->req->method = $method;
		$this->req->action = $action;
		foreach ($params as $k => $v) $this->req->$k = $v;
		$this->c->process($this->req, $this->res);
	}
}
