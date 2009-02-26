<?php
if (!$account->is_admin())
	access_denied();

if (is_post()) {
	$menu = new Menu(array('type' => $_POST['type'], 'parent' => 0 /*primary*/));
	if ($menu->type == 'board') {
		$board = Board::find_by_name($_POST['board_name']);
		$menu->name = $board->get_title();
		$menu->create();
		$menu->set_attribute('board_name', $board->name);
	} else if ($menu->type == 'dashboard') {
		$menu->name = $_POST['dashboard_name'];
		$menu->create();
	} else if ($menu->type == 'page') {
		$menu->name = $_POST['page_title'];
		$menu->body = $_POST['page_body'];
		$menu->create();
	}
}
