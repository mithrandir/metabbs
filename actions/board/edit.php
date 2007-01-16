<?php
if (!$account->is_admin()) {
	access_denied();
}
function get_styles() {
	$skins = array();
	$dir = @opendir('styles');
	if ($dir) {
		while ($file = readdir($dir)) {
			if ($file[0] != '.' && is_dir('styles/'.$file)) {
				$skins[] = $file;
			}
		}
		closedir($dir);
	}
	return $skins;
}
if (is_post()) {
	if ($_GET['tab'] == 'general') {
		$_board = new Board($_POST['board']);
		if (empty($_board->name)) {
			$flash = 'Board name is empty.';
		} else if ($_board->name != $board->name && !$_board->validate()) {
			$flash = "Board '$_board->name' already exists.";
		}
		if (isset($flash)) {
			$skin = '_admin';
			render('edit');
			return;
		}
	} else if ($_GET['tab'] == 'skin') {
		if ($board->skin != $_POST['board']['skin']) {
			// reset style
			$board->style = '';
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
//$skins = get_skins();
$styles = get_styles();
render('edit');
?>
