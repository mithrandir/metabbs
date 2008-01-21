<?php
require_once "../lib/request.php";

class RequestTest extends UnitTestCase {
	function setUp() {
		$this->request = new AbstractRequest;
	}

	function testIsPost() {
		$this->assertFalse($this->request->is_post());
		$this->request->method = 'POST';
		$this->assertTrue($this->request->is_post());
	}

	function testIsXHR() {
		$this->assertFalse($this->request->is_xhr());
		$this->request->requested_with = 'XMLHttpRequest';
		$this->assertTrue($this->request->is_xhr());
	}

	function testGenericRequest() {
		$_SERVER = array('REQUEST_METHOD' => 'POST', 'HTTP_X_REQUESTED_WITH' => 'blah blah', 'PATH_INFO' => '/controller/action/id');
		$_GET = array('a' => '1', 'b' => 2, 'method' => 'haxx!');
		$_POST = array('b' => 3, 'c' => 4);
		$r = new Request;

		$this->assertEqual('POST', $r->method);
		$this->assertEqual('blah blah', $r->requested_with);
		$this->assertEqual('controller', $r->controller);
		$this->assertEqual('action', $r->action);
		$this->assertEqual('id', $r->id);
		$this->assertEqual('1', $r->a);
		$this->assertEqual('3', $r->b);
		$this->assertEqual('4', $r->c);
	}
}
