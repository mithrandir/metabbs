<?php
require_once "../lib/uri_parser.php";

class URIParserTest extends UnitTestCase {
	function setUp() {
		$this->p = new URIParser;
	}

	function testRoot() {
		$this->assertFalse($this->p->parse('/'));
	}

	function testBoardUrl() {
		$this->assertEqual(array('board', 'index', 'test'), $this->p->parse('/test'));
		$this->assertEqual(array('board', 'action', 'test'), $this->p->parse('/test/action'));
	}

	function testPostUrl() {
		$this->assertEqual(array('post', 'index', '42'), $this->p->parse('/test/42'));
		$this->assertEqual(array('post', 'action', '42'), $this->p->parse('/test/42/action'));
	}

	function testAttachmentUrl() {
		$this->assertEqual(array('attachment', 'index', '3_pic.jpg'), $this->p->parse('/test/42/attachments/3_pic.jpg'));
	}

	// 여기서부터는 예전 방식 주소 테스트 (대표로 account 컨트롤러)
	function testControllerOnly() {
		$this->assertEqual(array('account', 'index', NULL), $this->p->parse('/account'));
		$this->assertEqual(array('account', 'index', NULL), $this->p->parse('/account/'));
	}

	function testControllerAndId() {
		$this->assertEqual(array('account', 'index', 'abc16'), $this->p->parse('/account/abc16'));
	}

	function testControllerAndAction() {
		$this->assertEqual(array('account', 'action', NULL), $this->p->parse('/account/action/'));
	}

	function testControllerAndActionAndId() {
		$this->assertEqual(array('account', 'action', 'abc16'), $this->p->parse('/account/action/abc16'));
	}
}
