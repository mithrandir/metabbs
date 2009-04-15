<?php
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
if (isset($params['style'])) {
	$board->change_style($params['style']);
	redirect_to(url_admin_for($board, 'edit', array('tab'=>'skin')));
}
if (is_post()) {
	$sorting_changed = false;
	if ($params['tab'] == 'general') {
		$_board = new Board($_POST['board']);
		if (empty($_board->name)) {
			$error_messages->add("Board name is empty");
		} else if ($_board->name != $board->name && !$_board->validate()) {
			$error_messages->add("Board '$_board->name' already exists");
		}
		$board->set_attribute('use_tag', $_POST['board']['use_tag']);
		$sorting_changed = $_board->order_by != $board->order_by;
		if ($error_messages->exists()) {
			$view = ADMIN_VIEW;
			return;
		}
	}
	$board->import($_POST['board']);
	$board->update();
	if ($params['tab'] == 'permission') {
		$board->set_attribute('always_show_list', $_POST['board']['always_show_list']);
		$board->set_attribute('restrict_write', $_POST['board']['restrict_write']);
		$board->set_attribute('restrict_comment', $_POST['board']['restrict_comment']);
		$board->set_attribute('restrict_access', $_POST['board']['restrict_access']);
		$board->set_attribute('restrict_attachment', $_POST['board']['restrict_attachment']);
		$board->set_attribute('always_show_comments', $_POST['board']['always_show_comments']);	
		$board->set_attribute('always_show_thumbnail', $_POST['board']['always_show_thumbnail']);	
	}
	if ($sorting_changed) $board->reset_sort_keys();
	if ($params['tab'] == 'category') {
		foreach ($_POST['categories'] as $_category) {
			if (!empty($_category)) {
				$board->add_category(new Category(array('name' => $_category)));
			}
		}
		$board->set_attribute('have_empty_item', $_POST['category']['have_empty_item']);
	} elseif ($params['tab'] == 'thumbnail') {
		$board->set_attribute('thumbnail_kind', $_POST['thumbnail']['kind']);
		$board->set_attribute('thumbnail_size', $_POST['thumbnail']['size']);
		$board->set_attribute('thumbnail_width', $_POST['thumbnail']['width']);
		$board->set_attribute('thumbnail_height', $_POST['thumbnail']['height']);

		$d = scandir('data/thumb');
		foreach($d as $f) {
			if ($f == '.' || $f == '..') continue;
			$path = 'data/thumb/'.$f;
			@unlink($path);
		}
	}
	Flash::set('Board has been changed');
	redirect_to(url_admin_for($board, 'edit', array('tab'=>$params['tab'])));
}

$styles = get_styles();
$current_style = $board->get_style();
$un = new UncategorizedPosts($board); 
?>
