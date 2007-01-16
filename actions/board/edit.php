<?php
if (!$account->is_admin()) {
	access_denied();
}
function get_styles() {
	$skins = array();
	$dir = @opendir('styles');
	if ($dir) {
		while ($file = readdir($dir)) {
			$path = 'styles/' . $file;
			if ($file[0] != '.' && is_dir($path)) {
				include $path.'/style.php';
				$skins[] = array($file, $style_name, $style_creator, $style_license);
			}
		}
		closedir($dir);
	}
	return $skins;
}
$license_mapping = array(
	'GPL' => '<a href="http://www.opensource.org/licenses/gpl-license.php">GNU General Public License (GPL)</a>',
	'MIT' => '<a href="http://www.opensource.org/licenses/mit-license.php">MIT License</a>'
);
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
$styles = get_styles();
render('edit');
?>
