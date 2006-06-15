<?php
if (!$user->is_admin()) {
	access_denied();
}
if (is_post()) {
	$_board = new Board($_POST['board']);
	if ($_board->name == $board->name || $_board->validate()) {
		$board->import($_POST['board']);
		$board->update();
		redirect_to(url_for('admin'));
	} else {
		$flash = "Board '$_board->name' already exists.";
	}
}
$skin = '_admin';
$skins = get_skins();
render('edit');
?>
