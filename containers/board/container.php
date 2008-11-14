<?php
// TODO: 공통 기능은 Controller 클래스로 빼내고 그걸 상속하게 함.

class BoardController {
	function BoardController($board) {
		$this->board = $board;
	}

	function process($view) {
	}
}
