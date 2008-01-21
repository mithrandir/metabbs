<?php
require_once "../lib/uri_parser.php";

class URIParserTest extends UnitTestCase {
	function setUp() {
		$this->p = new URIParser;
	}

	function testRoot() {
		$this->assertFalse($this->p->parse('/'));
	}

	function testControllerOnly() {
		$this->assertEqual(array('controller', 'index', NULL), $this->p->parse('/controller'));
		$this->assertEqual(array('controller', 'index', NULL), $this->p->parse('/controller/'));
	}

	function testControllerAndId() {
		$this->assertEqual(array('controller', 'index', 'abc16'), $this->p->parse('/controller/abc16'));
	}

	function testControllerAndAction() {
		$this->assertEqual(array('controller', 'action', NULL), $this->p->parse('/controller/action/'));
	}

	function testControllerAndActionAndId() {
		$this->assertEqual(array('controller', 'action', 'abc16'), $this->p->parse('/controller/action/abc16'));
	}
}
