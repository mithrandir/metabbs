<?php
 
if (!$params['id']) {
	header('HTTP/1.1 404 Not Found');
	print_notice(i('No board name'), i('Please append the board name.'));
}
$board = Board::find($params['id']);
if (!$board->exists()) {
	header('HTTP/1.1 404 Not Found');
	print_notice(i('Board not found'), i("Board %s doesn't exist.", $params['board-name']));
}


if (is_post()) {
	$sorting_changed = false;

	if ($_GET['tab'] == 'general') {
		$_board = new Board($_POST['board']);
		if (empty($_board->name)) {
			$error_messages->add('Board name is empty', 'name');
		} else if ($_board->name != $board->name && !$_board->validate()) {
			$error_messages->add("Board '$_board->name' already exists", 'name');
		}
		// name 형식 추가
		$board->set_attribute('use_tag', $_POST['board']['use_tag']);
		$board->set_attribute('use_captcha', $_POST['board']['use_captcha']);
		$sorting_changed = $_board->order_by != $board->order_by;
	}
	$board->import($_POST['board']);
	$board->update();

	if ($_GET['tab'] == 'permission') {
		$board->set_attribute('always_show_list', $_POST['board']['always_show_list']);
		$board->set_attribute('restrict_write', $_POST['board']['restrict_write']);
		$board->set_attribute('restrict_comment', $_POST['board']['restrict_comment']);
		$board->set_attribute('restrict_access', $_POST['board']['restrict_access']);
	}
	if ($sorting_changed) $board->reset_sort_keys();
	if ($_GET['tab'] == 'category') {
		foreach ($_POST['categories'] as $_category) {
			if (!empty($_category)) {
				$board->add_category(new Category(array('name' => $_category)));
			}
		}
		$board->set_attribute('have_empty_item', $_POST['category']['have_empty_item']);
	}
	if(!$error_messages->exists()) {	
		Flash::set(i('Well corrected'));
		redirect_to(url_for_admin('board', 'edit', array('id'=> $board->id, 'tab'=>$_GET['tab'])));
	}
}
//$styles = get_styles();
$current_style = $board->get_style();
$un = new UncategorizedPosts($board);
?>
