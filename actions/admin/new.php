<?php
if (is_post()) {
	$board = new Board($_POST['board']);
	if ($board->validate()) {
		$board->create();
		redirect_to(url_for('admin'));
	} else {
		$flash = "Board '$board->name' already exists.";
	}
}
$board = new Board;
$skins = get_skins();
render('edit');
?>
