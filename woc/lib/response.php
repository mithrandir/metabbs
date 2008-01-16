<?php
class AbstractResponse {
	var $body;

	function send() {
	}
}

class Response extends AbstractResponse {
	function send() {
		echo $this->body;
	}
}
