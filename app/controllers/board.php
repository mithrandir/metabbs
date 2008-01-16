<?php
require_once dirname(__FILE__)."/../models/board.php";

class BoardController extends Controller {
	function action_index() {
		$this->board = Board::find_by_name($this->request->id);
	}
}
