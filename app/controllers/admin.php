<?php
require_once dirname(__FILE__)."/../models/board.php";

class AdminController extends Controller {
	function action_index() {
		$this->boards = Board::find_all();
	}
}
?>
