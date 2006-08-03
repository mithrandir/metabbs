<?php
$board = new Board(array('name' => $_POST['name']));
if ($board->validate()) {
	$board->create();
	redirect_to(url_for('admin'));
} else {
	$flash = "Board '$board->name' already exists.";
	$boards = Board::find_all();
	render('index');
}
?>
