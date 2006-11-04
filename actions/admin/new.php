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

// Local Variables:
// mode: php
// tab-width: 4
// c-basic-offset: 4
// indet-tabs-mode: t
// End:
// vim: set ts=4 sts=4 sw=4 noet:
?>
