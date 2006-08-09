<?php
if (!$account->is_admin()) {
	access_denied();
}
if (is_post()) {
	if ($_GET['tab'] == 'general') {
		$_board = new Board($_POST['board']);
		if ($_board->name != $board->name && Board::find_by_name($_board->name)) {
			$flash = "Board '$_board->name' already exists.";
		}
	}
	$board->import($_POST['board']);
	$board->update();
	if ($_GET['tab'] == 'category') {
		foreach ($_POST['categories'] as $_category) {
			if (!empty($_category)) {
				$board->add_category(new Category(array('name' => $_category)));
			}
		}
	}
	redirect_to(url_for($board, 'edit', array('tab'=>$_GET['tab'])));
}
$skin = '_admin';
$skins = get_skins();
render('edit');
?>
