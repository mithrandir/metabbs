<?php
require_once "../lib/response.php";

class ResponseTest extends UnitTestCase {
	function testSend() {
		$response = new Response;
		$response->body = 'hi';

		ob_start();
		$response->send();
		$this->assertEqual('hi', ob_get_contents());
		ob_end_clean();
	}
}
