<?php
$board = new Board(array('name' => $_POST['name']));
if (empty($_POST['name'])) {
	echo "Board name is empty.";
	exit;
} else if (!$board->validate()) {
	header('HTTP/1.1 409 Conflict');
	echo "Board '$board->name' already exists.";
	exit;
} else {
	$board->create();
	if (is_xhr()) {
		include('app/views/admin/_board.php');
		exit;
	} else {
		redirect_to(url_for('admin'));
	}
}
?>
