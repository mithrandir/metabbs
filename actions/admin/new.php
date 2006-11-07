<?php
$board = new Board(array('name' => $_POST['name']));
if (empty($_POST['name'])) {
	$flash = "Board name is empty.";
} else if (!$board->validate()) {
	$flash = "Board '$board->name' already exists.";
} else {
	$board->create();
	redirect_to(url_for('admin'));
}
$boards = Board::find_all();
render('index');
?>
