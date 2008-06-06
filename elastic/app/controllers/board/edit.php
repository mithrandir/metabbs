<?php
if (!$account->is_admin()) {
	access_denied();
}
function get_styles() {
	$styles = array();
	$dir = @opendir('styles');
	if ($dir) {
		while ($file = readdir($dir)) {
			$path = 'styles/' . $file;
			if ($file[0] != '.' && is_dir($path)) {
				$styles[] = new Style($file);
			}
		}
		closedir($dir);
	}
	return $styles;
}
$license_mapping = array(
	'GPL' => '<a href="http://www.opensource.org/licenses/gpl-license.php">GNU General Public License (GPL)</a>',
	'MIT' => '<a href="http://www.opensource.org/licenses/mit-license.php">MIT License</a>'
);
if (isset($_GET['style'])) {
	$board->change_style($_GET['style']);
	redirect_to(url_for($board, 'edit', array('tab'=>'skin')));
}
if (is_post()) {
	$sorting_changed = false;
	if ($_GET['tab'] == 'general') {
		$_board = new Board($_POST['board']);
		if (empty($_board->name)) {
			$flash = 'Board name is empty.';
		} else if ($_board->name != $board->name && !$_board->validate()) {
			$flash = "Board '$_board->name' already exists.";
		}
		$sorting_changed = $_board->order_by != $board->order_by;
		if (isset($flash)) {
			$view = ADMIN_VIEW;
			return;
		}
	}
	$board->import($_POST['board']);
	$board->update();
	if ($_GET['tab'] == 'permission')
		$board->set_attribute('always_show_list', $_POST['board']['always_show_list']);
	if ($sorting_changed) $board->reset_sort_keys();
	if ($_GET['tab'] == 'category') {
		foreach ($_POST['categories'] as $_category) {
			if (!empty($_category)) {
				$board->add_category(new Category(array('name' => $_category)));
			}
		}
	}
	redirect_to(url_for($board, 'edit', array('tab'=>$_GET['tab'])));
}
$view = ADMIN_VIEW;
$styles = get_styles();
$current_style = $board->get_style();
?>
