<?php
$board = new Board(array('name' => $_POST['name']));
if (empty($_POST['name'])) {
	$flash = "Board name is empty.";
} else if (!$board->validate()) {
	$flash = "Board '$board->name' already exists.";
	exit;
} else {
	$board->create();
	//redirect_to(url_for('admin'));
	include('skins/_admin/_board.php');
	exit;
}
$boards = Board::find_all();
$action = 'index';
?>
