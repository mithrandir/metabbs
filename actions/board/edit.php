<?php
if (!$account->is_admin()) {
	access_denied();
}
if (is_post()) {
	$_board = new Board($_POST['board']);
	if ($_board->name == $board->name || $_board->validate()) {
		$board->import($_POST['board']);
		$board->update();
		if (isset($_POST['categories'])) {
			foreach ($_POST['categories'] as $_category) {
				if (!empty($_category)) {
					$category = new Category;
					$category->board_id = $board->id;
					$category->name = $_category;
					$category->create();
				}
			}
		}
		redirect_to(url_for($board, 'edit', array('tab'=>$_GET['tab'])));
	} else {
		$flash = "Board '$_board->name' already exists.";
	}
}
$skin = '_admin';
$skins = get_skins();
render('edit');
?>
